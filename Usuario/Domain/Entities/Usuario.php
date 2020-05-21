<?php

namespace Usuario\Domain\Entities;

class Usuario
{
    private int $id = 0;

    private string $titulo;

    private string $email;

    private string $hashSenha;

    public static function novo(string $titulo, string $email, string $hashSenha)
    {
        return new self($titulo, $email, $hashSenha);
    }

    private function __construct(string $titulo, string $email, string $hashSenha)
    {
        $this->titulo = $titulo;
        $this->email = $email;
        $this->hashSenha = $hashSenha;
    }

    public function id($id = null)
    {
        if (is_int($id)) {
            if ($this->id > 0) {
                throw new \RuntimeException('Id do usuário já foi definido.');
            }

            $this->id = $id;
        }

        return $this->id;
    }

    public function titulo()
    {
        return $this->titulo;
    }

    public function email()
    {
        return $this->email;
    }

    public function hashSenha()
    {
        return $this->hashSenha;
    }
}
