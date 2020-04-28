<?php

namespace App\Feed\Interfaces\Adapters;

use Domain\Feed\Entities\Feed;

interface BuscadorDeArtigosAdapterInterface
{
    public function buscar(string $link, string $aPartirDe = '') : array;
}
