<?php

namespace Usuario\App\Requests;

class AutenticarUsuarioRequest
{
    private string $nome;

    private string $email;

    public function __construct(string $nome, string $email)
    {
        $this->nome = $nome;
        $this->email = $email;
    }

    public function nome()
    {
        return $this->nome;
    }

    public function email()
    {
        return $this->email;
    }
}
