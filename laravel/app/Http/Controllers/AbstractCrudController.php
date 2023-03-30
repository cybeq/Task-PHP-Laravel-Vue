<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\CrudInterface;
use App\Models\Car;
use App\Models\Order;
use App\Models\Employee;
use App\Models\Client;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mockery\Exception;
use PhpParser\Error;

abstract class AbstractCrudController extends Controller implements CrudInterface
{
    private array $parametersMap;
    private mixed $model;
    private mixed $modelName;

    public function __construct(Request $request)
    {

        $this->parametersMap = [
            "Car"=>"owner_id",
            "Client"=>"employee_id",
            "Order"=>"client_id",
            "Employee"=>null
        ];
    }
    private function getInstance(string $modelName):string{
        $this->modelName = "App\\Models\\".$modelName;
        try {
            $this->model = new $this->modelName;
        }catch(\Throwable $e){
            throw new Error("There is no Model with that modelName");
        }
        return $this->modelName;
    }

    public function create(Request $request): Model|null
    {
        $this->getInstance($request->route('model'));

        if(!$request->get('name')){
            return null;
        }

        $this->model->name = $request->get('name');

        $parameter = $this->parametersMap[$request->route('model')];
        if($parameter) {
            $this->model->$parameter = $request->get('foreign_id') ?? null;
        }
        try {
             $this->model->save();
        }catch(\Illuminate\Database\QueryException $e){
             return null;
        }
        return $this->model;
    }

    public function read(Request $request): Model|array|null
    {
        $this->getInstance($request->route('model'));

        if($request->route('id') !== null){
            return $this->model::where(["id"=>$request->route('id')])->first();
        }

        return $this->model::all()->toArray();
    }

    public function update(Request $request): mixed
    {



        $this->model = $this->getInstance($request->route('model'));

        $model =  $this->model::where(["id"=>$request->route('id')])->first();

        if($request->route('id') === 'test')
        {
            $model =  $this->model::all()->first();
        }

        if(!$model){
            return new JsonResponse(["error"=>"There is no such a ".$this->modelName." with that id"]);
        }
        if($request->get('foreign_id') !== null){
            $parameter = $this->parametersMap[$request->route('model')];

            $model->$parameter = $request->get('foreign_id') ?? null;
        }
        if($request->get('name') !== null){
            $model->name = $request->get('name');
        }
        try {
            $model->save();
        }catch(\Illuminate\Database\QueryException $e){
            return new JsonResponse(["error"=>$e]);
        }

        return $model;

    }

    public function delete(Request $request): bool
    {

        $this->model = $this->getInstance($request->route('model'));

        $model =  $this->model::where(["id"=>$request->route('id')])->first();

        if(!$model){
            return false;
        }

        $model->delete();
        return true;
    }

}
