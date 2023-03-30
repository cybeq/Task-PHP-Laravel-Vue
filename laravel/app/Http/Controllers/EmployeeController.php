<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\CrudInterface;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller implements CrudInterface
{
    //
    public function create(Request $request): Employee|null
    {

    }

    public function read(Request $request): array
    {
        if(!$request->get('name')) {
            return Employee::all()->toArray();
        }
        return Employee::where(["name"=>$request->get('name')])->get()->toArray();
    }

    public function update(Request $request): Employee|null
    {

    }

    public function delete(Request $request): bool
    {

    }
}
