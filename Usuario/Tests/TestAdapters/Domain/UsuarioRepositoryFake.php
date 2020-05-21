<?php

namespace Usuario\Tests\TestAdapters\Domain;

use Usuario\Domain\Entities\Usuario;
use Usuario\Domain\Repositories\UsuarioRepositoryInterface;

class UsuarioRepositoryFake implements UsuarioRepositoryInterface
{
    private $usuarios = [];

    private $chamadasDeMetodos = [
        'buscarPeloEmail' => 0,
        'salvar' => 0,
    ];

    // public function buscar(int $id)
    // {
    //     foreach ($this->feeds as $feed) {
    //         if ($feed->id() == $id) {
    //             return $feed;
    //         }
    //     }

    //     return null;
    // }

    public function buscarPeloEmail(string $email) : ?Usuario
    {
        $this->chamadasDeMetodos['buscarPeloEmail']++;

        foreach ($this->usuarios as $usuario) {
            if ($usuario->email() == $email) {
                return $usuario;
            }
        }

        return null;
    }

    public function salvar(Usuario $usuario) : void
    {
        $this->chamadasDeMetodos['salvar']++;

        $this->usuarios[] = $usuario;

        $usuario->id(
            count($this->usuarios)
        );
    }

    public function qtdChamadasDeMetodo($metodo)
    {
        return $this->chamadasDeMetodos[$metodo];
    }
}
