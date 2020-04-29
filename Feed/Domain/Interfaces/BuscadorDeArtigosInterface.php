<?php

namespace Feed\Domain\Interfaces;

use Feed\Domain\Entities\Feed;

interface BuscadorDeArtigosInterface
{
    public function buscarTodos(Feed $feed) : array;

    public function buscarNovos(Feed $feed) : array;
}
