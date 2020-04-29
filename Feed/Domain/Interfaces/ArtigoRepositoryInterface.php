<?php

namespace Feed\Domain\Interfaces;

use Feed\Domain\Entities\Artigo;

interface ArtigoRepositoryInterface
{
    public function todos() : array;

    public function salvar(Artigo $feed) : void;

    public function salvarVarios(array $artigos) : void;
}
