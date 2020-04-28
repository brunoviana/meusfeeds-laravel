<?php

namespace App\Feed\UseCases;

use Domain\Feed\Interfaces\Repositories\FeedRepositoryInterface;
use Domain\Feed\Entities\Feed;

use App\Feed\Requests\CriarNovoFeedRequest;
use App\Feed\Responses\CriarNovoFeedResponse;
use App\Feed\Exceptions\FeedJaExisteException;

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

        $feed = $this->criaNovoFeed();

        $this->salvarFeed($feed);

        return $this->responder($feed);
    }

    public function criaNovoFeed()
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
    }

    public function falharSeFeedJaExistir()
    {
        $feed = $this->feedRepository->buscarPeloLink($this->request->linkRss());

        if ($feed) {
            throw new FeedJaExisteException('Já existe um feed com esse link');
        }

        return $feed;
    }
}
