<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use App\Event;
use App\Exceptions\EventException;

class EventController extends Controller
{
    private $model;

    public function __construct(Event $event){
        $this->model = $event;
    }

    public function index(){
        try{
            $events = $this->model->all();
            return response()->json($events);
        }catch(EventException $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_BAD_REQUEST);
        }catch(Exception $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id){
        try{
            $event = $this->model->find($id);
            throw_if(empty($event), new EventException(EventException::EVENT_NOT_FOUND));

            return response()->json($event);
        }catch(EventException $ex){
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

            $event = $this->model->create($data);

            return  response()->json($event);
        }catch(EventException $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_BAD_REQUEST);
        }catch(Exception $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update($id, Request $request){
        try{
            $event = $this->model->find($id);
            throw_if(empty($event), new EventException(EventException::EVENT_NOT_FOUND));

            $data = $request->all();
            $event->fill($data);
            $validator = Validator::make($event->toArray(),  $event->rules());

            if ($validator->fails()) {
                return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
            }

            $event->save();

            return response()->json($event);
        }catch(EventException $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_BAD_REQUEST);
        }catch(Exception $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id){
        try{
            $event = $this->model->find($id);
            throw_if(empty($event), new EventException(EventException::EVENT_NOT_FOUND));
            $event->delete();
            return response()->json('Event removed');
        }catch(EventException $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_BAD_REQUEST);
        }catch(Exception $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
