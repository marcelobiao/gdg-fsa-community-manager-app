<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use App\Import;
use App\People;
use App\Exceptions\ImportException;
use App\People_event;
use App\Utils\SymplaImporterETL;

class ImportController extends Controller
{
    private $model;

    public function __construct(Import $import){
        $this->model = $import;
    }

    public function index(){
        try{
            $import = $this->model->all();
            return response()->json($import);
        }catch(ImportException $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_BAD_REQUEST);
        }catch(Exception $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id){
        try{
            $import = $this->model->find($id);
            throw_if(empty($import), new ImportException(ImportException::IMPORT_NOT_FOUND));

            return response()->json($import);
        }catch(ImportException $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_BAD_REQUEST);
        }catch(Exception $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request){
        try{
            $data = $request->all();
            $validator = Validator::make($data, $this->model->rules());

            if ($validator->fails()) {
                return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
            }

            $import = $this->model->create($data);
            $file = $request->file('file');

            $this->symplaFileImport($file, $data['event_id'], $import->id);

            return response()->json("Registros importados com sucesso!");
        }catch(ImportException $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_BAD_REQUEST);
        }catch(Exception $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update($id, Request $request){
        try{
            $import = $this->model->find($id);
            throw_if(empty($import), new ImportException(ImportException::IMPORT_NOT_FOUND));

            $data = $request->all();
            $import->fill($data);
            $validator = Validator::make($import->toArray(), $import->rules());

            if ($validator->fails()) {
                return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
            }

            $import->save();

            return response()->json($import);
        }catch(ImportException $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_BAD_REQUEST);
        }catch(Exception $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id){
        try{
            $import = $this->model->find($id);
            throw_if(empty($import), new ImportException(ImportException::IMPORT_NOT_FOUND));
            $import->delete();
            return response()->json('People removed');
        }catch(ImportException $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_BAD_REQUEST);
        }catch(Exception $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function symplaFileImport($file, $event_id, $import_id){
        $importer = new SymplaImporterETL($file, $event_id, $import_id);
        $importer->import();
    }

    /**
     * Método realiza o checkin manualmente dos participantes do evento
     * Método recebe um csv no campo 'file', contendo as colunas 'datahora' e 'email'
     */
    public function manualCheckIn(Request $request){
        try{
            $file = $request->file('file');
            $feedback = [];
            $path = $file->getRealPath();
            $csv_string = file_get_contents($path);
            $rows = str_getcsv($csv_string, "\n");
            foreach($rows as $row){
                $rowDecode = str_getcsv($row, ',');
                $rowDecode[0] = str_replace("/", "-", $rowDecode[0]);
                
                $people = People::where('email', $rowDecode[1])->first();
                if(empty($people->id)){
                    $feedback[] = $rowDecode[1] . ',Pessoa não encontrada';
                    continue;
                }
                
                $peopleEvent = People_event::where('people_id', $people->id)->where('event_id', 7)->first();
                if(empty($peopleEvent->id)){
                    $feedback[] = $rowDecode[1] . ',Ingresso não encontrada';
                    continue;
                }
                
                $url = 'https://api.sympla.com.br/public/v3/events/887489/participants/ticketNumber/'.$peopleEvent->ticket_hash.'/checkIn';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, '');
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'S_TOKEN:'.env('SYMPLA_TOKEN'),
                ));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $server_output = curl_exec($ch);
                curl_close ($ch);
                //dd($server_output);

                $peopleEvent->fill(['check_in' => 1, 'check_in_date' => $rowDecode[0]]);
                $peopleEvent->update();
                $feedback[] = $rowDecode[1] . ',Check-In';
            }
            
            return response()->json($feedback);
        }catch(ImportException $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_BAD_REQUEST);
        }catch(Exception $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
