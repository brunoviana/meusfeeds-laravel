<?php

namespace App\Feed\UseCases;

use App\Feed\Requests\DescobrirFeedsPelaUrlRequest;
use App\Feed\Responses\DescobrirFeedsPelaUrlResponse;
use App\Feed\Interfaces\Services\BuscadorDeFeedsServiceInterface;

class DescobrirFeedsPelaUrl
{
    private $request;

    private $buscadorDeFeeds;

    public function __construct(
        DescobrirFeedsPelaUrlRequest $request,
        BuscadorDeFeedsServiceInterface $buscadorDeFeeds
    ) {
        $this->request = $request;
        $this->buscadorDeFeeds = $buscadorDeFeeds;
    }

    public function executar()
    {
        $url = $this->request->url();

        $feeds = $this->buscadorDeFeeds->buscar($url);

        return new DescobrirFeedsPelaUrlResponse($feeds);
    }
}
