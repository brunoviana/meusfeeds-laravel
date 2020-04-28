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
        $feeds = $this->buscadorDeFeeds->buscar(
            $this->url()
        );

        return $this->responder($feeds);
    }

    public function responder($feeds)
    {
        return new DescobrirFeedsPelaUrlResponse($feeds);
    }

    public function url()
    {
        return $this->request->url();
    }
}
