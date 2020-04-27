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

    public function corrigeUrlDaBusca($url)
    {
        if (substr($url, -1) != '/') {
            $url .= '/';
        }

        return $url;
    }

    public function corrigeUrlDoFeed($url, $feedUrl)
    {
        if (substr($feedUrl, 0, 4) != 'http') {
            $feedUrl = $url . $feedUrl;
        }

        return $feedUrl;
    }

    public function montaArrayDeFeed($feed)
    {
        return [
            'titulo' => $feed->getTitle(),
            'link_rss' => $feed->getLink(),
            'descricao' => $feed->getDescription(),
        ];
    }

    public function buscar(string $url) : array
    {
        $url = $this->corrigeUrlDaBusca($url);

        $feedsDescobertos = $this->feedIo->discover($url);

        $feeds = [];

        foreach ($feedsDescobertos as $feed) {
            $feedUrl = $this->corrigeUrlDoFeed($url, $feed);

            $feedsEncontrados = $this->feedIo->read($feed);

            $ultimosArtigos = [];

            foreach ($feedsEncontrados->getFeed() as $indice => $artigo) {
                if ($indice == 3) {
                    break;
                }

                $ultimosArtigos[] = $artigo->getTitle();
            }

            $feeds[] = array_merge(
                $this->montaArrayDeFeed($feedsEncontrados->getFeed()),
                [
                    'ultimos_artigos' => $ultimosArtigos
                ]
            );
        }

        return $feeds;
    }
}
