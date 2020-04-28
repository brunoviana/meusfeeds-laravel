<?php

namespace Framework\Mappers;

use Domain\Feed\Entities\Feed;
use Domain\Feed\ValueObjects\Data;
use Domain\Feed\ValueObjects\Autor;

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

        foreach ($model->artigos as $artigoModel) {
            $d = explode('-', $artigoModel->data_publicacao);

            $feed->artigos()->adicionar(
                $artigoModel->titulo,
                $artigoModel->descricao,
                $artigoModel->link,
                new Autor($artigoModel->autor),
                new Data($d[0], $d[1], $d[2]),
                $artigoModel->lido
            );
        }

        return $feed;
    }
}
