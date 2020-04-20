<?php

namespace Framework\Adapters\Repositories;

use App\Feed\Interfaces\FeedRepositoryInterface;
use App\Feed\Responses\CriarNovoFeedResponse;

use Domain\Feed\Entities\Feed;

use Framework\Models\Feed as FeedModel;

class FeedRepositoryAdapter implements FeedRepositoryInterface
{
    public function buscarPeloLink(string $link)
    {
    }

    public function save(Feed $feed) : CriarNovoFeedResponse
    {
        $feedModel = new FeedModel();
        $feedModel->map($feed);
        $feedModel->save();

        $feed->id($feedModel->id);

        $response = new CriarNovoFeedResponse($feed);

        return $response;
    }
}
