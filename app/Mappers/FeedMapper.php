<?php

namespace Framework\Mappers;

use Feed\Domain\Entities\Feed;

use Framework\Models\Feed as FeedModel;

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
        $feed = Feed::novo(
            $model->titulo,
            $model->link_rss
        );

        if ($model->id) {
            $feed->id($model->id);
        }

        return $feed;
    }
}
