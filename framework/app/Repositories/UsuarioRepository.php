<?php

namespace Framework\Repositories;

use Framework\Mappers\UsuarioMapper;
use Usuario\Domain\Entities\Usuario;
use Framework\Models\Usuario as UsuarioModel;

// use Framework\Models\Feed as FeedModel;
use Usuario\Domain\Repositories\UsuarioRepositoryInterface;

class UsuarioRepository implements UsuarioRepositoryInterface
{
    // public function buscar(int $id)
    // {
    //     $feedModel = FeedModel::find($id);

    //     if ($feedModel) {
    //         return FeedMapper::criaEntidade($feedModel);
    //     }

    //     return null;
    // }

    public function buscarPeloEmail(string $email) : ?Usuario
    {
        $usuarioModel = UsuarioModel::where('email', $email)->first();

        if ($usuarioModel) {
            return UsuarioMapper::criaEntidade($usuarioModel);
        }

        return null;
    }

    public function salvar(Usuario $usuario) : void
    {
        $usuarioModel = UsuarioMapper::criaModel($usuario);

        $usuarioModel->save();

        if (!$usuario->id()) {
            $usuario->id(
                $usuarioModel->id
            );
        }
    }
}
