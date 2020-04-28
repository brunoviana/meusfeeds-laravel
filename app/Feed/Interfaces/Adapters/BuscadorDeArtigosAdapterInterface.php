<?php

namespace App\Feed\Interfaces\Adapters;

interface BuscadorDeArtigosAdapterInterface
{
    public function buscar(string $aPartirDe = '') : array;
}
