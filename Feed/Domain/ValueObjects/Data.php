<?php

namespace Feed\Domain\ValueObjects;

class Data
{
    private int $ano;

    private int $mes;

    private int $dia;

    public function __construct(int $ano = 0, int $mes = 0, int $dia = 0)
    {
        $this->ano = $ano;
        $this->mes = $mes;
        $this->dia = $dia;
    }

    public static function agora()
    {
        return new self(
            date('Y'),
            date('m'),
            date('d')
        );
    }

    public function ano()
    {
        return $this->ano;
    }

    public function mes()
    {
        return $this->mes;
    }

    public function dia()
    {
        return $this->dia;
    }

    public function vazio()
    {
        return !($this->dia && $this->mes && $this->ano);
    }

    public function formatoPadrao()
    {
        return implode('-', [
            sprintf("%04d", $this->ano),
            sprintf("%02d", $this->mes),
            sprintf("%02d", $this->dia),
        ]);
    }
}
