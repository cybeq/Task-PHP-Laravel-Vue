<?php

namespace App\Http\Controllers;

use App\Http\Services\CrudService;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;

class CrudController extends AbstractCrudController
{
    public function authenticate(Request $request){
        if($request->get('password') === config('app.userAuthPassword')  && $request->get('name') === config('app.userAuthName')){;
            $secret = env('JWT_SECRET');
            $payload = [
                'sub'=>'auth_guard',
                'iat'=>time(),
                'exp'=>time() + (60*60*24)
            ];
            return ['token' => (string) JWT::encode($payload, $secret, "HS256")];
        }
    return ['fail' => 'auth'];
    }
}
