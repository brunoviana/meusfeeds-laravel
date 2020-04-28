<?php

namespace Framework\Adapters\Feed;

use Domain\Feed\Entities\Feed;

use App\Feed\Interfaces\Adapters\BuscadorDeArtigosAdapterInterface;

use FeedIo\FeedIo;

class BuscadorDeArtigosAdapter implements BuscadorDeArtigosAdapterInterface
{
    private $feedIo;

    public function __construct(FeedIo $feedIo)
    {
        $this->feedIo = $feedIo;
    }

    public function buscar(Feed $feed, string $aPartirDe = '') : array
    {
        if (!empty($aPartirDe)) {
            $result = $this->feedIo->readSince($feed->linkRss(), new \DateTime($aPartirDe));
        } else {
            $result = $this->feedIo->read($feed->linkRss());
        }

        $artigosEncontrados = [];

        foreach ($result->getFeed() as $item) {
            $artigosEncontrados[] = [
                'titulo' => $item->getTitle(),
                'descricao' => $item->getDescription(),
                'link' => $item->getLink(),
                'autor' => $item->getAuthor()->getName(),
                'data_publicacao' => $item->getLastModified()->format('Y-m-d'),
            ];
        }

        return $artigosEncontrados;
    }
}
