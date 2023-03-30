<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\CrudInterface;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller implements CrudInterface
{
    //
    public function create(Request $request): Car|null
    {

    }

    public function read(Request $request): array
    {
        if(!$request->get('name')) {
            return Car::all()->toArray();
        }
        return Car::where(["name"=>$request->get('name')])->get()->toArray();

    }

    public function update(Request $request): Car|null
    {

    }

    public function delete(Request $request): bool
    {

    }
}
