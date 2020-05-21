<?php

namespace Feed\App\UseCases;

use Feed\Domain\Services\FeedService;
use Feed\App\Requests\SincronizarFeedRequest;
use Feed\Domain\Interfaces\BuscadorDeArtigosInterface;

use Feed\Domain\Repositories\ArtigoRepositoryInterface;

class SincronizarFeed
{
    private $request;

    private $buscadorDeArtigos;

    private $artigoRepository;

    public function __construct(
        SincronizarFeedRequest $request,
        ArtigoRepositoryInterface $artigoRepository,
        BuscadorDeArtigosInterface $buscadorDeArtigos
    ) {
        $this->request = $request;
        $this->artigoRepository = $artigoRepository;
        $this->buscadorDeArtigos = $buscadorDeArtigos;
    }

    public function executar()
    {
        $feedService = new FeedService();

        $feedService->setBuscadorDeArtigos($this->buscadorDeArtigos);
        $feedService->setArtigoRepository($this->artigoRepository);

        $feedService->sincronizarNovosArtigos(
            $this->feed()
        );
    }

    public function feed()
    {
        return $this->request->feed();
    }
}
