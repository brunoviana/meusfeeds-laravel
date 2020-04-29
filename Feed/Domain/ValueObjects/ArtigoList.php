<?php

namespace Feed\Domain\ValueObjects;

use Feed\Domain\ValueObjects\Artigo;
use Feed\Domain\ValueObjects\Data;
use Feed\Domain\ValueObjects\Autor;

class ArtigoList implements \Iterator, \Countable
{
    private $artigos = [];

    private $primeiroIndice = null;

    public function adicionar(
        string $titulo,
        string $descricao,
        string $link,
        Autor $autor,
        Data $dataPublicacao,
        int $lido = 0
    ) {
        $indice = md5($link);

        if (!$this->primeiroIndice) {
            $this->primeiroIndice = $indice;
        }

        $this->artigos[$indice] = new Artigo(
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
        $indice = $this->primeiroIndice;

        if ($indice) {
            return $this->artigos[$indice];
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
