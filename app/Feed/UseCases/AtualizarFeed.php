<?php

namespace App\Feed\UseCases;

use Domain\Feed\Interfaces\Repositories\FeedRepositoryInterface;
use Domain\Feed\Entities\Feed;

use App\Feed\Requests\AtualizarFeedRequest;
use App\Feed\Responses\AtualizarFeedResponse;
use App\Feed\Services\BuscadorDeArtigosService;
use App\Feed\Interfaces\Adapters\BuscadorDeArtigosAdapterInterface;

class AtualizarFeed
{
    protected $feedRepository;

    protected $request;

    protected $buscadorDeArtigos;

    public function __construct(
        FeedRepositoryInterface $feedRepository,
        AtualizarFeedRequest $request,
        BuscadorDeArtigosAdapterInterface $buscadorDeArtigosAdapter
    ) {
        $this->feedRepository = $feedRepository;
        $this->request = $request;
        $this->buscadorDeArtigos = new BuscadorDeArtigosService($buscadorDeArtigosAdapter);
    }

    public function executar()
    {
        $feed = $this->feed();

        $this->buscarEAtualizar($feed);

        return $this->responder($feed);
    }

    public function buscarEAtualizar(Feed $feed)
    {
        return $this->buscadorDeArtigos->buscarEAtualizar($feed);
    }

    public function feed()
    {
        return $this->feedRepository->buscar(
            $this->feedId()
        );
    }

    public function feedId()
    {
        return $this->request->feedId();
    }

    public function responder(Feed $feed)
    {
        return new AtualizarFeedResponse($feed);
    }
}
