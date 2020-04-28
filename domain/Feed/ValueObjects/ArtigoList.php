<?php

namespace Domain\Feed\ValueObjects;

use Domain\Feed\ValueObjects\Artigo;
use Domain\Feed\ValueObjects\Data;
use Domain\Feed\ValueObjects\Autor;

class ArtigoList implements \Iterator, \Countable
{
    private $artigos = [];

    public function adicionar(
        string $titulo,
        string $descricao,
        string $link,
        Autor $autor,
        Data $dataPublicacao,
        int $lido = 0
    ) {
        $this->artigos[] = new Artigo(
            $titulo,
            $descricao,
            $link,
            $autor,
            $dataPublicacao,
            $lido
        );
    }

    public function primeiro()
    {
        if (count($this->artigos)) {
            return $this->artigos[0];
        }

        return null;
    }

    public function rewind()
    {
        return reset($this->artigos);
    }

    public function current()
    {
        return current($this->artigos);
    }

    public function key()
    {
        return key($this->artigos);
    }

    public function next()
    {
        return next($this->artigos);
    }

    public function valid()
    {
        return key($this->artigos) !== null;
    }

    public function count()
    {
        return count($this->artigos);
    }
}
