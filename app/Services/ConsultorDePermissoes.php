<?php

namespace Framework\Services;

use Framework\Models\EmailPermitido;
use Usuario\Domain\Interfaces\ConsultorDePermissoesInterface;

class ConsultorDePermissoes implements ConsultorDePermissoesInterface
{
    public function usuarioPodeSeAutenticar(string $email) : bool
    {
        return EmailPermitido::where('email', $email)->first() ? true : false;
    }
}
