<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Usuario;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        $usuario = new Usuario();
        $usuario->id = 1;
        $usuario->nome = $request->input('nome');
        $usuario->email = $request->input('email');
        $usuario->foto = $request->input('foto');

        // if (! $token = auth()->attempt($credentials)) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }

        $token = auth('api')->login($usuario);

        return response([
            'status' => 'success'
        ])
        ->header('Authorization', $token);

        // return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();

        return response([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }

    public function user(Request $request)
    {
        return $request->user();
    }

    public function refresh(Request $request)
    {
        return response([
            'status' => 'success'
        ]);
    }
}
