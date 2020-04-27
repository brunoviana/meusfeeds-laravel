<?php

namespace Framework\Adapters\Feed\Services;

use Domain\Feed\Interfaces\Services\BuscadorDeArtigosServiceInterface;
use Domain\Feed\ValueObjects\Data;
use Domain\Feed\ValueObjects\ArtigoList;

use FeedIo\FeedIo;

class BuscadorDeArtigosService implements BuscadorDeArtigosServiceInterface
{
    private $feedIo;

    public function __construct(FeedIo $feedIo)
    {
        $this->feedIo = $feedIo;
    }

    public function buscar(Data $aPartirDe) : ArtigoList
    {
        return new ArtigoList();
    }
}
