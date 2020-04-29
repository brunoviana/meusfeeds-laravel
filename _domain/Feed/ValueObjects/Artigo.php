<?php

namespace Domain\Feed\ValueObjects;

use Domain\Feed\ValueObjects\Data;
use Domain\Feed\ValueObjects\Autor;

class Artigo
{
    private string $titulo;

    private string $descricao;

    private string $link;

    private Autor $autor;

    private Data $dataPublicacao;

    private int $lido;

    public function __construct(
        string $titulo,
        string $descricao,
        string $link,
        Autor $autor,
        Data $dataPublicacao,
        int $lido = 0
    ) {
        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->link = $link;
        $this->autor = $autor;
        $this->dataPublicacao = $dataPublicacao;
        $this->lido = $lido;
    }

    public function titulo()
    {
        return $this->titulo;
    }

    public function descricao()
    {
        return $this->descricao;
    }

    public function link()
    {
        return $this->link;
    }

    public function autor()
    {
        return $this->autor;
    }

    public function dataPublicacao()
    {
        return $this->dataPublicacao;
    }

    public function lido()
    {
        return (bool) $this->lido;
    }

    public function marcarComoLido()
    {
        $this->lido = 1;
    }

    public function marcarComoNaoLido()
    {
        $this->lido = 0;
    }
}
