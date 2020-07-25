<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use App\Import;
use App\Exceptions\ImportException;
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
}
