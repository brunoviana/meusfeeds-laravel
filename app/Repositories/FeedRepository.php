<?php

namespace App\Repositories;

use MeusFeeds\Feeds\Domain\Entities\Feed;
use App\Mappers\FeedMapper;

use App\Models\Feed as FeedModel;
use MeusFeeds\Feeds\Domain\Repositories\FeedRepositoryInterface;

class FeedRepository implements FeedRepositoryInterface
{
    public function buscar(int $id)
    {
        $feedModel = FeedModel::find($id);

        if ($feedModel) {
            return FeedMapper::criaEntidade($feedModel);
        }

        return null;
    }

    public function buscarPeloLink(string $link)
    {
        $feedModel = FeedModel::where('link_rss', $link)->first();

        if ($feedModel) {
            return FeedMapper::criaEntidade($feedModel);
        }

        return null;
    }

    public function salvar(Feed $feed) : void
    {
        $feedModel = FeedMapper::criaModel($feed);

        $feedModel->save();

        if (!$feed->id()) {
            $feed->id(
                $feedModel->id
            );
        }
    }
}
