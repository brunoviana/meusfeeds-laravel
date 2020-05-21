<?php

namespace Feed\Domain\Entities;

use Feed\Domain\ValueObjects\Data;
use Feed\Domain\ValueObjects\Autor;

class Artigo
{
    const LIDO = 1;

    const NAO_LIDO = 0;

    private int $id = 0;

    private string $titulo;

    private string $descricao;

    private string $link;

    private Autor $autor;

    private Data $dataPublicacao;

    private int $lido;

    private int $feedId;

    public static function novo(
        string $titulo,
        string $descricao,
        string $link,
        Autor $autor,
        Data $dataPublicacao,
        int $feedId = 0,
        int $lido = self::NAO_LIDO
    ) : Artigo {
        return new self($titulo, $descricao, $link, $autor, $dataPublicacao, $feedId, $lido);
    }

    private function __construct(
        string $titulo,
        string $descricao,
        string $link,
        Autor $autor,
        Data $dataPublicacao,
        int $feedId = 0,
        int $lido = 0
    ) {
        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->link = $link;
        $this->autor = $autor;
        $this->dataPublicacao = $dataPublicacao;
        $this->feedId = $feedId;
        $this->lido = $lido;
    }

    public function id($id = null)
    {
        if (is_int($id)) {
            if ($this->id > 0) {
                throw new \RuntimeException('Id do artigo já foi definido.');
            }

            $this->id = $id;
        }

        return $this->id;
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

    public function lido($lido = null)
    {
        if ($lido !== null) {
            $this->lido = (bool) $lido;
        }

        return (bool) $this->lido;
    }

    public function feedId()
    {
        return $this->feedId;
    }
}
