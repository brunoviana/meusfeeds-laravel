<?php

namespace App\Services;

use App\Models\EmailPermitido;
use MeusFeeds\Usuarios\Domain\Interfaces\ConsultorDePermissoesInterface;

class ConsultorDePermissoes implements ConsultorDePermissoesInterface
{
    public function usuarioPodeSeAutenticar(string $email) : bool
    {
        return EmailPermitido::where('email', $email)->first() ? true : false;
    }
}
