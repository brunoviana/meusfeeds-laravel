<?php

namespace App\Mappers;

use MeusFeeds\Usuarios\Domain\Entities\Usuario;
use App\Models\Usuario as UsuarioModel;

class UsuarioMapper
{
    public static function criaModel(Usuario $usuario)
    {
        $usuarioModel = UsuarioModel::find($usuario->id());

        if (!$usuarioModel) {
            $usuarioModel = new UsuarioModel();
        }

        $usuarioModel->nome = $usuario->nome();
        $usuarioModel->email = $usuario->email();

        return $usuarioModel;
    }

    public static function criaEntidade(UsuarioModel $model)
    {
        $usuario = new Usuario(
            $model->nome,
            $model->email
        );

        if ($model->id) {
            $usuario->id($model->id);
        }

        return $usuario;
    }
}
