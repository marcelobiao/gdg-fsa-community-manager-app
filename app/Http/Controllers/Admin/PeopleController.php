<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use App\People;
use App\Exceptions\PeopleException;

class PeopleController extends Controller
{
    private $model;

    public function __construct(People $people){
        $this->model = $people;
    }

    public function index(){
        try{
            $people = $this->model->all();
            return response()->json($people);
        }catch(PeopleException $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_BAD_REQUEST);
        }catch(Exception $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id){
        try{
            $people = $this->model->find($id);
            throw_if(empty($people), new PeopleException(PeopleException::PEOPLE_NOT_FOUND));

            return response()->json($people);
        }catch(PeopleException $ex){
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

            $people = $this->model->create($data);

            return  response()->json($people);
        }catch(PeopleException $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_BAD_REQUEST);
        }catch(Exception $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update($id, Request $request){
        try{
            $people = $this->model->find($id);
            throw_if(empty($people), new PeopleException(PeopleException::PEOPLE_NOT_FOUND));

            $data = $request->all();
            $people->fill($data);
            $validator = Validator::make($people->toArray(), $people->rules());

            if ($validator->fails()) {
                return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
            }

            $people->save();

            return response()->json($people);
        }catch(PeopleException $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_BAD_REQUEST);
        }catch(Exception $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id){
        try{
            $people = $this->model->find($id);
            throw_if(empty($people), new PeopleException(PeopleException::PEOPLE_NOT_FOUND));
            $people->delete();
            return response()->json('People removed');
        }catch(PeopleException $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_BAD_REQUEST);
        }catch(Exception $ex){
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
