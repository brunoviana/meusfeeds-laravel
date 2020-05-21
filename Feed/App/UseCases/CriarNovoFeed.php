<?php

namespace Feed\App\UseCases;

use Feed\Domain\Entities\Feed;
use Feed\Domain\Services\FeedService;
use Feed\App\Requests\CriarNovoFeedRequest;
use Feed\App\Responses\CriarNovoFeedResponse;
use Feed\Domain\Repositories\FeedRepositoryInterface;

use Feed\Domain\Interfaces\BuscadorDeArtigosInterface;
use Feed\Domain\Repositories\ArtigoRepositoryInterface;

class CriarNovoFeed
{
    private $request;

    private $buscadorDeArtigos;

    private $artigoRepository;

    private $feedRepository;

    public function __construct(
        CriarNovoFeedRequest $request,
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
        $feed = $this->criaFeed();

        return $this->responder($feed);
    }

    public function criaFeed()
    {
        $feedService = new FeedService();

        $feedService->setBuscadorDeArtigos($this->buscadorDeArtigos);
        $feedService->setFeedRepository($this->feedRepository);
        $feedService->setArtigoRepository($this->artigoRepository);

        return $feedService->criarNovoFeed(
            $this->request->titulo(),
            $this->request->linkRss()
        );
    }

    public function responder(Feed $feed)
    {
        return new CriarNovoFeedResponse($feed);
    }
}
