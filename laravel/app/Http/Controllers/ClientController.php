<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\CrudInterface;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller implements CrudInterface
{
    //
    public function create(Request $request): Client|null
    {

    }

    public function read(Request $request): array
    {
        if(!$request->get('name')) {
            return Client::all()->toArray();
        }
        return Client::where(["name"=>$request->get('name')])->get()->toArray();
    }

    public function update(Request $request): Client|null
    {

    }

    public function delete(Request $request): bool
    {

    }
}
