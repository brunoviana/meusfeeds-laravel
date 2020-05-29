<?php

namespace App\Mappers;

use MeusFeeds\Feeds\Domain\Entities\Artigo;
use MeusFeeds\Feeds\Domain\ValueObjects\Data;
use MeusFeeds\Feeds\Domain\ValueObjects\Autor;

use App\Models\Artigo as ArtigoModel;

class ArtigoMapper
{
    public static function criaModel(Artigo $artigo)
    {
        $artigoModel = ArtigoModel::find($artigo->id());

        if (!$artigoModel) {
            $artigoModel = new ArtigoModel();
        }

        $artigoModel->titulo = $artigo->titulo();
        $artigoModel->descricao = $artigo->descricao();
        $artigoModel->link = $artigo->link();
        $artigoModel->autor = $artigo->autor()->nome();
        $artigoModel->data_publicacao = $artigo->dataPublicacao()->formatoPadrao();
        $artigoModel->lido = (int) $artigo->lido();
        $artigoModel->feed_id = (int) $artigo->feedId();

        return $artigoModel;
    }

    public static function criaEntidade(ArtigoModel $model)
    {
        $artigo = new Artigo(
            $model->titulo,
            $model->descricao,
            $model->link,
            new Autor($model->autor),
            new Data(
                $model->data_publicacao->format('Y'),
                $model->data_publicacao->format('m'),
                $model->data_publicacao->format('d')
            ),
            $model->feed_id,
            (int) $model->lido
        );

        if ($model->id) {
            $artigo->id($model->id);
        }

        return $artigo;
    }
}
