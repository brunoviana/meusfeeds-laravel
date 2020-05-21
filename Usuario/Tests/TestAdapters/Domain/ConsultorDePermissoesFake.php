<?php

namespace Usuario\Tests\TestAdapters\Domain;

use Usuario\Domain\Interfaces\ConsultorDePermissoesInterface;

class ConsultorDePermissoesFake implements ConsultorDePermissoesInterface
{
    public function usuarioPodeSeAutenticar(string $email) : bool
    {
        if ($email == 'usuario.nao.permitido@gmail.com') {
            return false;
        }

        return true;
    }
}
