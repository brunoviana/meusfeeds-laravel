<?php

namespace App\Feed\UseCases;

use Domain\Feed\Interfaces\Repositories\FeedRepositoryInterface;
use Domain\Feed\Interfaces\Services\BuscadorDeArtigosServiceInterface;
use Domain\Feed\Entities\Feed;

use App\Feed\Requests\CriarNovoFeedRequest;
use App\Feed\Responses\CriarNovoFeedResponse;
use App\Feed\Exceptions\FeedJaExisteException;

class CriarNovoFeed
{
    private CriarNovoFeedRequest $request;

    private FeedRepositoryInterface $feedRepository;

    private BuscadorDeArtigosServiceInterface $buscadorDeArtigosService;

    public function __construct(
        CriarNovoFeedRequest $request,
        FeedRepositoryInterface $feedRepository,
        BuscadorDeArtigosServiceInterface $buscadorDeArtigosService
    ) {
        $this->request = $request;
        $this->feedRepository = $feedRepository;
        $this->buscadorDeArtigosService = $buscadorDeArtigosService;
    }

    public function executar()
    {
        $feed = $this->feedRepository->buscarPeloLink($this->request->linkRss());

        if ($feed) {
            throw new FeedJaExisteException('Já existe um feed com esse link');
        }

        $feed = new Feed(
            $this->request->titulo(),
            $this->request->linkRss(),
            $this->buscadorDeArtigosService
        );

        $id = $this->feedRepository->save($feed);

        $feed->id($id);

        $response = new CriarNovoFeedResponse($feed);

        return $response;
    }
}
