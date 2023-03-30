<?php

namespace App\Http\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface CrudInterface{
    public function create(Request $request):Model|null;
    public function read  (Request $request):Model|array|null;
    public function update(Request $request):Model|null;
    public function delete(Request $request):bool;
}
