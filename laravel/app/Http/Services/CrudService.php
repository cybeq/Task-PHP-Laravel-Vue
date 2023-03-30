<?php

namespace App\Http\Services;

use App\Http\Interfaces\CrudInterface;
use App\Notifications\CarAssignedNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;

class CrudService
{
    private static array $parametersMap = [
            "Car"=>"client_id",
            "Client"=>"employee_id",
            "Order"=>"client_id",
            "Employee"=>null
        ];
    public static function create(string $name,Model $model, string $modelName, string|null $foreign, float|null $price): Model|null{
        if(!$name){
            return null;
        }
        $model->name = $name;

        $parameter = self::$parametersMap[$modelName];
        if($parameter) {
            $model->$parameter = $foreign;
        }
        if($modelName === 'Order'){
            $model->price = $price ?? 0 ;
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
    public static function update(bool $test, string $instance, string|null $id, string|null $foreign, string $name, string $modelName, string|null $price): mixed{
        $model =  $instance::where(["id"=>$id])->first();

        if($test)
        {
            $model =  $instance::all()->first();
        }

        $modelNameEndOfPath = explode('\\', $modelName);
        $modelNameEndOfPath = end($modelNameEndOfPath);
        if(!$model){
            return new JsonResponse(["error"=>"There is no such a ".$modelNameEndOfPath." with that id"]);
        }
        if($foreign !== null && $modelNameEndOfPath !== 'Employee'){
            $parameter = self::$parametersMap[$modelNameEndOfPath];
            if($modelNameEndOfPath ==='Car')
            {
                if($model->$parameter !== $foreign)
                {
                    Notification::route('mail', [
                        'tcmworkouts@gmail.com' => 'Barrett Blair',
                    ])->notify(new CarAssignedNotification($model));
//                    $model->notify(new CarAssignedNotification($model));
                }
            }
            $model->$parameter = $foreign;

        }


        if($modelName === 'Order'){
            $model->price = 350 ;
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
