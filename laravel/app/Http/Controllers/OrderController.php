<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\CrudInterface;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller implements CrudInterface
{
    //
    public function create(Request $request): Order|null
    {

    }

    public function read(Request $request): array
    {
        if(!$request->get('name')) {
            return Order::all()->toArray();
        }
        return Order::where(["name"=>$request->get('name')])->get()->toArray();
    }

    public function update(Request $request): Order|null
    {

    }

    public function delete(Request $request): bool
    {

    }
}
