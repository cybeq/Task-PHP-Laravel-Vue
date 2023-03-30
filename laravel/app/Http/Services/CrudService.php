<?php

namespace App\Http\Services;

use App\Http\Interfaces\CrudInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class CrudService
{
    private static array $parametersMap = [
            "Car"=>"owner_id",
            "Client"=>"employee_id",
            "Order"=>"client_id",
            "Employee"=>null
        ];
    public static function create($name, $model, $modelName, $foreign): Model|null{
        if(!$name){
            return null;
        }
        $model->name = $name;

        $parameter = self::$parametersMap[$modelName];
        if($parameter) {
            $model->$parameter = $foreign;
        }
        try {
            $model->save();
        }catch(\Illuminate\Database\QueryException $e){
            return null;
        }
        return $model;
    }
    public static function read(string|null $id, Model $model): Model|array|null{
        if($id !== null){
            return $model::where(["id"=>$id])->first();
        }
        return $model::all()->toArray();
    }
    public static function update(bool $test, string $instance, string|null $id, string|null $foreign, string $name, string $modelName): mixed{
        $model =  $instance::where(["id"=>$id])->first();
        if($test)
        {
            $model =  $instance::all()->first();
        }
        if(!$model){
            return new JsonResponse(["error"=>"There is no such a ".$modelName." with that id"]);
        }
        if($foreign !== null){
            $parameter = self::$parametersMap[$modelName];

            $model->$parameter = $foreign;
        }
        if($name !== null){
            $model->name = $name;
        }
        try {
            $model->save();
        }catch(\Illuminate\Database\QueryException $e){
            return new JsonResponse(["error"=>$e]);
        }

        return $model;
    }

    public static function delete(string $instance, string $id): bool{
        $model =  $instance::where(["id"=>$id])->first();

        if(!$model){
            return false;
        }

        $model->delete();
        return true;
    }
}
