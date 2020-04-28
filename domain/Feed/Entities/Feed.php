<?php

namespace Domain\Feed\Entities;

use Domain\Feed\ValueObjects\ArtigoList;
use Domain\Feed\ValueObjects\Data;
use Domain\Feed\ValueObjects\Autor;

class Feed
{
    private int $id = 0;

    private string $titulo;

    private string $linkRss;

    private ArtigoList $artigos;

    public static function novo(string $titulo, string $linkRss) : Feed
    {
        return new self($titulo, $linkRss);
    }

    private function __construct(string $titulo, string $linkRss)
    {
        $this->titulo = $titulo;
        $this->linkRss = $linkRss;
        $this->artigos = new ArtigoList();
    }

    public function id($id=null)
    {
        if (is_int($id)) {
            $this->id = $id;
        }
        
        return $this->id;
    }

    public function titulo()
    {
        return $this->titulo;
    }

    public function linkRss()
    {
        return $this->linkRss;
    }

    public function artigos() : ArtigoList
    {
        return $this->artigos;
    }

    public function adicionarArtigo(
        string $titulo,
        string $descricao,
        string $link,
        Autor $autor,
        Data $dataPublicacao,
        int $lido = 0
    ) {
        $this->artigos->adicionar(
            $titulo,
            $descricao,
            $link,
            $autor,
            $dataPublicacao,
            $lido
        );
    }
}
