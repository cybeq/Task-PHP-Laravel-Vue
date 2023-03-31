<?php

namespace App\Http\Services;

use App\Http\Interfaces\CrudInterface;
use App\Models\Car;
use App\Models\Client;
use App\Models\Order;
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
    public static function create(string $name,Model $model, string $modelName, string|null $foreign, float|null $price, string|null $orderId): Model|null{
        if(!$name){
            return null;
        }
        $model->name = $name;

        $parameter = self::$parametersMap[$modelName];
        if($parameter && $modelName ==='Client') {
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
        if($orderId!== null && $modelName === 'Client'){
            $model->orders()->attach(Order::find($orderId));
        }
        return $model;
    }
    public static function read(string|null $id, Model $model, string $modelName): Model|array|null{
        if($id !== null && $modelName==='Client'){
            $client = Client::find($id);
            $model =  $model::find($id);
            $model->cars = $client->cars()->get();
            $model->orders = $client->orders()->get();
            return $model;
        }
        if($id !== null && $modelName==='Car'){
            $car = Car::find($id);
            $model =  $model::find($id);
            $model->clients = $car->clients()->get();
            return $model;
        }
        
        if($id !== null){
            return $model::find($id);
        }
        if($modelName === 'Client'){
            $modelGroup = $model::all();
            foreach ( $modelGroup as $singleModel ){
                if(!$singleModel->id){
                    continue;
                }
                $client = Client::find($singleModel->id);
                $singleModel->cars = $client->cars()->get();
                $singleModel->orders = $client->orders()->get();
            }
            return $modelGroup->toArray();
        }

        if($modelName === 'Car'){
            $modelGroup = $model::all();
            foreach ( $modelGroup as $singleModel ){
                if(!$singleModel->id){
                    continue;
                }
                $car = Car::find($singleModel->id);
                $singleModel->clients = $car->clients()->get();
            }
            return $modelGroup->toArray();
        }

        return $model::all()->toArray();
    }
    public static function update(bool $test, string|null $carId, string $instance, string|null $id, string|null $foreign, string|null $name, string $modelName, string|null $price, string|null $orderId): mixed{
        $model =  $instance::find($id);
        if($name !== null )$model->name = $name;
        if($test)
        {
            $model =  $instance::all()->first();
        }

        $modelNameEndOfPath = explode('\\', $modelName);
        $modelNameEndOfPath = end($modelNameEndOfPath);
        if(!$model){
            return new JsonResponse(["error"=>"There is no such a ".$modelNameEndOfPath." with that id"]);
        }
        if($foreign !== null && $modelNameEndOfPath === 'Client' ){
            $parameter = self::$parametersMap[$modelNameEndOfPath];
            $model->$parameter = $foreign;
        }
        if($foreign !== null && $modelNameEndOfPath === 'Car'){
            Notification::route('mail', ['tcmworkouts@gmail.com' => 'Barrett Blair',])
                         ->notify(new CarAssignedNotification($model));
            $model->clients()->syncWithoutDetaching(Client::find($foreign));
        }

        if($price !== null && $modelNameEndOfPath === 'Order'){
            $model->price = $price;
        }
        try {
            $model->save();
        }catch(\Illuminate\Database\QueryException $e){
            return new JsonResponse(["error"=>$e]);
        }

        if($orderId!== null && $modelNameEndOfPath === 'Client'){
            $model->orders()->attach(Order::find($orderId));
        }
        if($carId!== null && $modelNameEndOfPath === 'Client'){
            $model->cars()->syncWithoutDetaching(Car::find($carId));
        }

        return $model;
    }

    public static function delete(string $instance, string $id): bool{
        $model =  $instance::find($id);

        if(!$model){
            return false;
        }

        $model->delete();
        return true;
    }
}
