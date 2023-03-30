<?php

namespace App\Http\Controllers;

use App\Http\Services\CrudService;
use App\Models\Client;
use Illuminate\Http\Request;


class CrudController extends AbstractCrudController
{
    public function getCarsByClient(Request $request){
          $client = Client::find($request->route('client_id'));
          return $client->cars()->get();
    }
}
