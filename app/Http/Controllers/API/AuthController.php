<?php

namespace App\Http\Controllers\API;

use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Models\ListaDeConvites;
use App\Http\Controllers\Controller;
use App\Repositories\UsuarioRepository;
use App\Mappers\UsuarioMapper;
use MeusFeeds\Usuarios\App\Exceptions\UsuarioNaoAutenticadoException;
use MeusFeeds\Usuarios\App\UseCases\AutenticarUsuario;
use MeusFeeds\Usuarios\App\Requests\AutenticarUsuarioRequest;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        $autenticaUsuario = new AutenticarUsuario(
            new AutenticarUsuarioRequest(
                $request->input('nome'),
                $request->input('email'),
                $request->input('foto')
            ),
            new UsuarioRepository(),
            new ListaDeConvites()
        );

        try {
            $response = $autenticaUsuario->executar();
        } catch (UsuarioNaoAutenticadoException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 401);
        }

        $token = auth('api')->login(
            UsuarioMapper::criaModel($response->usuario())
        );

        return response([
            'status' => 'success'
        ])
        ->header('Authorization', $token);
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
