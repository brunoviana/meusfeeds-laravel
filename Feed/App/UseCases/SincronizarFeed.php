<?php

namespace Feed\App\UseCases;

use Feed\Domain\Services\FeedService;
use Feed\Domain\Interfaces\FeedRepositoryInterface;
use Feed\Domain\Interfaces\ArtigoRepositoryInterface;
use Feed\Domain\Interfaces\BuscadorDeArtigosInterface;

use Feed\App\Requests\SincronizarFeedRequest;
use Feed\App\Exceptions\FeedNaoEncontradoException;

class SincronizarFeed
{
    private $request;

    private $buscadorDeArtigos;

    private $artigoRepository;

    private $feedRepository;

    public function __construct(
        SincronizarFeedRequest $request,
        FeedRepositoryInterface $feedRepository,
        ArtigoRepositoryInterface $artigoRepository,
        BuscadorDeArtigosInterface $buscadorDeArtigos
    ) {
        $this->request = $request;
        $this->feedRepository = $feedRepository;
        $this->artigoRepository = $artigoRepository;
        $this->buscadorDeArtigos = $buscadorDeArtigos;
    }

    public function executar()
    {
        $feedService = new FeedService();

        $feedService->setBuscadorDeArtigos($this->buscadorDeArtigos);
        $feedService->setArtigoRepository($this->artigoRepository);
        $feedService->setFeedRepository($this->feedRepository);

        $feedService->sincronizarNovosArtigos(
            $this->feed()
        );
    }

    public function feed()
    {
        $feed = $this->feedRepository->buscar(
            $this->feedId()
        );

        if (!$feed) {
            throw new FeedNaoEncontradoException('O feed não existe.');
        }

        return $feed;
    }

    public function feedId()
    {
        return $this->request->feedId();
    }
}
