<?php

namespace App\Feed\UseCases;

use Domain\Feed\Interfaces\Repositories\FeedRepositoryInterface;
use Domain\Feed\Entities\Feed;

use App\Feed\Requests\CriarNovoFeedRequest;
use App\Feed\Responses\CriarNovoFeedResponse;
use App\Feed\Exceptions\FeedJaExisteException;
use App\Feed\Exceptions\FeedNaoEncontradoException;

class CriarNovoFeed
{
    private CriarNovoFeedRequest $request;

    private FeedRepositoryInterface $feedRepository;

    public function __construct(
        CriarNovoFeedRequest $request,
        FeedRepositoryInterface $feedRepository
    ) {
        $this->request = $request;
        $this->feedRepository = $feedRepository;
    }

    public function executar()
    {
        $this->falharSeFeedJaExistir();

        $feed = $this->salvarFeed(
            $this->novoFeed()
        );

        return $this->responder($feed);
    }

    public function novoFeed()
    {
        return Feed::novo(
            $this->request->titulo(),
            $this->request->linkRss()
        );
    }

    public function responder(Feed $feed)
    {
        return new CriarNovoFeedResponse($feed);
    }

    public function salvarFeed(Feed $feed)
    {
        $id = $this->feedRepository->save($feed);

        $feed->id($id);

        return $feed;
    }

    public function falharSeFeedJaExistir()
    {
        try {
            $this->feedRepository->buscarPeloLink($this->request->linkRss());
        } catch (FeedNaoEncontradoException $e) {
            return;
        }

        throw new FeedJaExisteException('Já existe um feed com esse link');
    }
}
