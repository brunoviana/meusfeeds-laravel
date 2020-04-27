<?php

namespace Domain\Feed\Interfaces\Services;

use Domain\Feed\ValueObjects\Data;
use Domain\Feed\ValueObjects\ArtigoList;

interface BuscadorDeArtigosServiceInterface
{
    public function buscar(Data $aPartirDe) : ArtigoList;
}
