<?php

namespace Usuario\Domain\Repositories;

use Usuario\Domain\Entities\Usuario;

interface UsuarioRepositoryInterface
{
    // public function buscar(int $id) : ?Usuario;

    public function buscarPeloEmail(string $email) : ?Usuario;

    public function salvar(Usuario $usuario) : void;
}
