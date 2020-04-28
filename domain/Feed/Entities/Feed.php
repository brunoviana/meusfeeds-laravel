<?php

namespace Domain\Feed\Entities;

use Domain\Feed\ValueObjects\ArtigoList;
use Domain\Feed\ValueObjects\Data;
use Domain\Feed\ValueObjects\Autor;

class Feed
{
    private int $id;

    private string $titulo;

    private string $linkRss;

    private ArtigoList $artigos;
    
    private Data $ultimaAtualizacao;

    public function __construct(string $titulo, string $linkRss, $ultimaAtualizacao = null)
    {
        $this->titulo = $titulo;
        $this->linkRss = $linkRss;
        $this->artigos = new ArtigoList();

        if (!$ultimaAtualizacao) {
            $ultimaAtualizacao = new Data();
        }

        $this->ultimaAtualizacao = $ultimaAtualizacao;
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

    public function ultimaAtualizacao() : Data
    {
        return $this->ultimaAtualizacao;
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

        $this->ultimaAtualizacao = Data::agora();
    }
}
