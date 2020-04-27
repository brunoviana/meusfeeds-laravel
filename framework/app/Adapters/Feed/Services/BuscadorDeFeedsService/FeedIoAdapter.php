<?php

namespace Framework\Adapters\Feed\Services\BuscadorDeFeedsService;

use FeedIo\FeedIo;

use App\Feed\Interfaces\Services\BuscadorDeFeedsServiceInterface;

class FeedIoAdapter implements BuscadorDeFeedsServiceInterface
{
    private $feedIo;

    public function __construct(FeedIo $feedIo)
    {
        $this->feedIo = $feedIo;
    }

    public function buscar(string $url) : array
    {
        if (substr($url, -1) != '/') {
            $url .= '/';
        }

        $feeds = $this->feedIo->discover($url);

        $feedsEncontrados = [];

        foreach ($feeds as $feed) {
            if (substr($feed, 0, 4) != 'http') {
                $feed = $url . $feed;
            }

            $result = $this->feedIo->read($feed);

            $ultimosArtigos = [];

            foreach ($result->getFeed() as $indice => $artigo) {
                if ($indice == 3) { // Só quero os 3 primeiros
                    break;
                }

                $ultimosArtigos[] = $artigo->getTitle();
            }

            $feedsEncontrados[] = [
                'titulo' => $result->getFeed()->getTitle(),
                'link_rss' => $result->getFeed()->getLink(),
                'descricao' => $result->getFeed()->getDescription(),
                'ultimos_artigos' => $ultimosArtigos,
            ];
        }

        return $feedsEncontrados;
    }
}
