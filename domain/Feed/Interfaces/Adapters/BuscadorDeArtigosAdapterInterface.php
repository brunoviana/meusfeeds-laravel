<?php

namespace Domain\Feed\Interfaces\Adapters;

interface BuscadorDeArtigosAdapterInterface
{
    public function buscar(string $aPartirDe = '') : array;
}
