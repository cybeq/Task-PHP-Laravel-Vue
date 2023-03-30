<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\CrudInterface;
use App\Http\Services\CrudService;
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

    private mixed $model;
    private mixed $modelName;

    public function __construct(Request $request){}
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
        return CrudService::create(
                                    $request->get('name'),
                                    $this->model,
                                    $request->route('model'),
                                    $request->get('foreign_id') ?? null,
                                    $request->get('price') ?? null
        );
    }

    public function read(Request $request): Model|array|null
    {
        $this->getInstance($request->route('model'));
        $id = $request->route('id');
        return CrudService::read(
                                    $id,
                                    $this->model,
                                    $this->modelName
        );
    }

    public function update(Request $request): mixed
    {
        $this->model = $this->getInstance($request->route('model'));
        return CrudService::update(
                           $request->route('id') === 'test',
                                $this->model, $request->route('id'),
                         $request->get('foreign_id') ?? null,
                                $request->get('name'),$this->modelName,
                           $request->get('price') ?? null
        );
    }

    public function delete(Request $request): bool
    {
        $this->model = $this->getInstance($request->route('model'));
        return CrudService::delete(
                                    $this->model,
                                    $request->route('id')
        );
    }

}
