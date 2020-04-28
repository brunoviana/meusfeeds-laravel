<?php

namespace Framework\Repositories\Feed;

use Domain\Feed\Interfaces\Repositories\FeedRepositoryInterface;
use Domain\Feed\Entities\Feed;

use App\Feed\Exceptions\FeedNaoEncontradoException;

use Framework\Models\Feed as FeedModel;

class FeedRepositoryAdapter implements FeedRepositoryInterface
{
    public function buscar(int $id) : Feed
    {
        $feedModel = FeedModel::find($id);

        if (!$feedModel) {
            throw new FeedNaoEncontradoException('Não foi possível encontrar Feed com id '.$id);
        }

        return $this->criaEntidade($feedModel);
    }

    public function buscarPeloLink(string $link) : Feed
    {
        $feedModel = FeedModel::where('link_rss', $link)->first();

        if (!$feedModel) {
            throw new FeedNaoEncontradoException('Não foi possível encontrar Feed com link '.$link);
        }

        return $this->criaEntidade($feedModel);
    }

    public function save(Feed $feed) : int
    {
        $feedModel = $this->criaModel($feed);

        $feedModel->save();

        $feedModel->artigos()->delete();

        foreach ($feed->artigos() as $artigo) {
            $feedModel->artigos()->create([
                'titulo' => $artigo->titulo(),
                'descricao' => $artigo->descricao(),
                'link' => $artigo->link(),
                'autor' => $artigo->autor()->nome(),
                'data_publicacao' => $artigo->dataPublicacao()->formatoPadrao(),
                'lido' => (int) $artigo->lido(),
            ]);
        }

        $feed->id(
            $feedModel->id
        );

        return $feedModel->id;
    }

    public function criaModel(Feed $feed)
    {
        $feedModel = FeedModel::find($feed->id());

        if (!$feedModel) {
            $feedModel = new FeedModel();
        }

        $feedModel->titulo = $feed->titulo();
        $feedModel->link_rss = $feed->linkRss();

        return $feedModel;
    }

    public function criaEntidade(FeedModel $model)
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
