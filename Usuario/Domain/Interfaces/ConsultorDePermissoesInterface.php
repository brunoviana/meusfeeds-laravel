<?php

namespace Usuario\Domain\Interfaces;

interface ConsultorDePermissoesInterface
{
    public function usuarioPodeSeAutenticar(string $email) : bool;
}
