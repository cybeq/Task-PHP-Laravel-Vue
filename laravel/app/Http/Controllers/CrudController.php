<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\CrudInterface;
use App\Models\Car;
use App\Models\Order;
use App\Models\Employee;
use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Mockery\Exception;

class CrudController extends Controller implements CrudInterface
{
    private array $parametersMap;
    private mixed $model;
    private mixed $modelName;

    public function __construct(Request $request)
    {

        $this->parametersMap = [
            "Car"=>"owner_id",
            "Client"=>"employee_id",
            "Order"=>"client_id"
        ];
    }
    private function getInstance(string $modelName){
        $this->modelName = "App\\Models\\".$modelName;
        $this->model = new $this->modelName;
    }

    public function create(Request $request): Model|null
    {
        $this->getInstance($request->route('model'));

        if(!$request->get('name')){
            return null;
        }

        $this->model->name = $request->get('name');
        $parameter = $this->parametersMap[$request->route('model')];
        try {
               $this->model->$parameter = $request->get('foreign_id') ?? null;
        }catch(Exception $e){}

        $this->model->save();
        return $this->model;
    }

    public function read(Request $request): Car|array|null
    {
        $this->getInstance($request->route('model'));

        if($request->route('id') !== null){
            return $this->model::where(["id"=>$request->route('id')])->first();
        }

        return $this->model::all()->toArray();
    }

    public function update(Request $request): Car|null
    {

    }

    public function delete(Request $request): bool
    {

    }
}
