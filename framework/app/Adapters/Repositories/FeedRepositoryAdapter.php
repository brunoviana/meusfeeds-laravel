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
        $feedModel = FeedModel::where('link_rss', $link)->first();

        if (!$feedModel) {
            return null;
        }

        return $feedModel->entity();
    }

    public function save(Feed $feed) : int
    {
        $feedModel = new FeedModel();
        $feedModel->map($feed);
        $feedModel->save();

        return $feedModel->id;
    }
}
