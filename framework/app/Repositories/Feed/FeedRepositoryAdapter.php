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

        return $feedModel->entity();
    }

    public function buscarPeloLink(string $link) : Feed
    {
        $feedModel = FeedModel::where('link_rss', $link)->first();

        if (!$feedModel) {
            throw new FeedNaoEncontradoException('Não foi possível encontrar Feed com link '.$link);
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
