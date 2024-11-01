<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        //set validation
        $validation = Validator::make($request->all(),[
            'username' => 'required',
            'password' => 'required',
        ]);

        // if validation fails
        if($validation->fails()){
            return response()->json($validation->errors(), 422);
        }

        // get credentials from request
        $credentials = $request->only('username', 'password');

        //if auth failed
        if(!$token = auth()->guard('api')->attempt($credentials)){
            return response()->json([
                'success' => false,
                'massage' => 'Username atau Password Anda Salah'
            ], 401);
        }

        // if auth success
        return response()->json([
            'success' => true,
            'user' => auth()->guard('api')->user(),
            'token' => $token
        ], 200);
    }
}
