<?php

namespace App\Feed\UseCases;

use App\Feed\Requests\CriarNovoFeedRequest;
use App\Feed\Interfaces\FeedRepositoryInterface;
use App\Feed\Exceptions\FeedJaExisteException;

use Domain\Feed\Entities\Feed;

class CriarNovoFeed
{
    private CriarNovoFeedRequest $request;

    private FeedRepositoryInterface $feedRepository;

    public function __construct(CriarNovoFeedRequest $request, FeedRepositoryInterface $feedRepository)
    {
        $this->request = $request;
        $this->feedRepository = $feedRepository;
    }

    public function executar()
    {
        $feed = $this->feedRepository->buscarPeloLink($this->request->linkRss());

        if ($feed) {
            throw new FeedJaExisteException('Já existe um feed com esse link');
        }

        $feed = new Feed(
            $this->request->titulo(),
            $this->request->linkRss()
        );

        return $this->feedRepository->save($feed);
    }
}
