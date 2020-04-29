<?php

namespace Feed\Tests\TestAdapters\Domain;

use Feed\Domain\Entities\Artigo;
use Feed\Domain\Interfaces\ArtigoRepositoryInterface;

class ArtigoRepositoryFake implements ArtigoRepositoryInterface
{
    private $artigos = [];

    public function todos() : array
    {
        return $this->artigos;
    }

    public function salvar(Artigo $artigo) : void
    {
        $this->artigos[] = $artigo;

        $artigo->id(
            count($this->artigos)
        );
    }

    public function salvarVarios(array $artigos) : void
    {
        foreach ($artigos as $artigo) {
            $this->salvar($artigo);
        }
    }
}
