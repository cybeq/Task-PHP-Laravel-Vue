<?php

namespace App\Http\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Js;

interface CrudInterface{
    public function create(Request $request):Model|null|JsonResponse;
    public function read  (Request $request):Model|array|null|JsonResponse;
    public function update(Request $request):mixed;
    public function delete(Request $request):bool;
}
