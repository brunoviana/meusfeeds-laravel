<?php

namespace Usuario\Domain\Entities;

class Usuario
{
    private int $id = 0;

    private string $nome;

    private string $email;

    public static function novo(string $nome, string $email)
    {
        return new self($nome, $email);
    }

    private function __construct(string $nome, string $email)
    {
        $this->nome = $nome;
        $this->email = $email;
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

    public function nome()
    {
        return $this->nome;
    }

    public function email()
    {
        return $this->email;
    }
}
