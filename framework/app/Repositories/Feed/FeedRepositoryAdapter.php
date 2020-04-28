<?php

namespace Framework\Repositories\Feed;

use Domain\Feed\Entities\Feed;
use Domain\Feed\ValueObjects\Data;
use Domain\Feed\Interfaces\Repositories\FeedRepositoryInterface;

use App\Feed\Exceptions\FeedNaoEncontradoException;

use Framework\Models\Feed as FeedModel;
use Framework\Mappers\FeedMapper;

class FeedRepositoryAdapter implements FeedRepositoryInterface
{
    public function buscar(int $id) : Feed
    {
        $feedModel = FeedModel::find($id);

        if (!$feedModel) {
            throw new FeedNaoEncontradoException('Não foi possível encontrar Feed com id '.$id);
        }

        return FeedMapper::criaEntidade($feedModel);
    }

    public function buscarPeloLink(string $link) : Feed
    {
        $feedModel = FeedModel::where('link_rss', $link)->first();

        if (!$feedModel) {
            throw new FeedNaoEncontradoException('Não foi possível encontrar Feed com link '.$link);
        }

        return FeedMapper::criaEntidade($feedModel);
    }

    public function save(Feed $feed) : int
    {
        $feedModel = FeedMapper::criaModel($feed);

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

    public function dataDaUltimaAtualizacao(Feed $feed) : Data
    {
        $feedModel = FeedMapper::criaModel($feed);

        $ultimoArtigo = $feedModel->artigos->last();

        if ($ultimoArtigo) {
            return new Data(
                $ultimoArtigo->created_at->format('Y'),
                $ultimoArtigo->created_at->format('m'),
                $ultimoArtigo->created_at->format('d')
            );
        }

        return new Data();
    }
}
