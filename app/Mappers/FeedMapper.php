<?php

namespace App\Mappers;

use MeusFeeds\Feeds\Domain\Entities\Feed;

use App\Models\Feed as FeedModel;

class FeedMapper
{
    public static function criaModel(Feed $feed)
    {
        $feedModel = FeedModel::find($feed->id());

        if (!$feedModel) {
            $feedModel = new FeedModel();
        }

        $feedModel->titulo = $feed->titulo();
        $feedModel->link_rss = $feed->linkRss();

        return $feedModel;
    }

    public static function criaEntidade(FeedModel $model)
    {
        $feed = new Feed(
            $model->titulo,
            $model->link_rss
        );

        if ($model->id) {
            $feed->id($model->id);
        }

        return $feed;
    }
}
