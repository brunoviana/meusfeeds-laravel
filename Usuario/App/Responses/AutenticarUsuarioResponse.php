<?php

namespace Usuario\App\Responses;

use Usuario\Domain\Entities\Usuario;

class AutenticarUsuarioResponse
{
    private Usuario $usuario;

    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    public function usuario()
    {
        return $this->usuario;
    }
}
