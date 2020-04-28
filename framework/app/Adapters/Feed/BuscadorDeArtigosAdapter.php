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

    public function buscar(string $link, string $aPartirDe = '') : array
    {
        dd($link);
        if (!empty($aPartirDe)) {
            $result = $this->feedIo->readSince($link, new \DateTime($aPartirDe));
        } else {
            $result = $this->feedIo->read($link);
        }

        $artigosEncontrados = [];

        foreach ($result->getFeed() as $item) {
            $artigosEncontrados[] = [
                'titulo' => $item->getTitle(),
                'descricao' => $item->getDescription(),
                'link' => $item->getLink(),
                'autor' => (string) $item->getAuthor()->getName(),
                'data_publicacao' => $item->getLastModified()->format('Y-m-d'),
            ];

            dd($artigosEncontrados);
        }

        return $artigosEncontrados;
    }
}
