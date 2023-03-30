<?php

namespace App\Http\Interfaces;

use App\Models\Car;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Order;
use Illuminate\Http\Request;

interface CrudInterface{
    public function create(Request $request):Car|Client|Order|Employee|null;
    public function read  (Request $request):array;
    public function update(Request $request):Car|Client|Order|Employee|null;
    public function delete(Request $request):bool;
}
