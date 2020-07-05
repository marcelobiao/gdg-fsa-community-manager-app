<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\People_event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\PeopleEventException;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class PeopleEventController extends Controller
{
    private $model;

    public function __construct(People_event $peopleEvent){
        $this->model = $peopleEvent;
    }

    public function index(){
        try{
            $peopleEvent = $this->model->all();
            return response()->json($peopleEvent);
        }catch(PeopleEventException $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_BAD_REQUEST);
        }catch(Exception $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id){
        try{
            $peopleEvent = $this->model->find($id);
            throw_if(empty($peopleEvent), new PeopleEventException(PeopleEventException::PEOPLE_EVENT_NOT_FOUND));

            return response()->json($peopleEvent);
        }catch(PeopleEventException $ex){
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

            $peopleEvent = $this->model->create($data);

            return  response()->json($peopleEvent);
        }catch(PeopleEventException $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_BAD_REQUEST);
        }catch(Exception $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update($id, Request $request){
        try{
            $peopleEvent = $this->model->find($id);
            throw_if(empty($peopleEvent), new PeopleEventException(PeopleEventException::PEOPLE_EVENT_NOT_FOUND));

            $data = $request->all();
            $peopleEvent->fill($data);
            $validator = Validator::make($peopleEvent->toArray(), $peopleEvent->rules());

            if ($validator->fails()) {
                return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
            }

            $peopleEvent->save();

            return response()->json($peopleEvent);
        }catch(PeopleEventException $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_BAD_REQUEST);
        }catch(Exception $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id){
        try{
            $peopleEvent = $this->model->find($id);
            throw_if(empty($peopleEvent), new PeopleEventException(PeopleEventException::PEOPLE_EVENT_NOT_FOUND));
            $peopleEvent->delete();
            return response()->json('People_Event removed');
        }catch(PeopleEventException $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_BAD_REQUEST);
        }catch(Exception $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
