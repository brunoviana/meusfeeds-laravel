<?php

namespace Feed\Domain\Services;

use Feed\Domain\Entities\Feed;
use Feed\Domain\Entities\Artigo;

class FeedService extends Service
{
    public function procurarFeedsPelaUrl(string $url)
    {
        return $this->getExtratorDeFeeds()->extrair($url);
    }

    public function criarNovoFeed(string $titulo, string $linkRss)
    {
        $feed = Feed::novo($titulo, $linkRss);

        $this->getFeedRepository()->salvar($feed);

        $artigos = $this->getBuscadorDeArtigos()->buscarTodos($feed);

        if ($artigos) {
            $this->getArtigoRepository()->salvarVarios($artigos);
        }

        return $feed;
    }

    public function sincronizarNovosArtigos(Feed $feed)
    {
        $artigos = $this->getBuscadorDeArtigos()->buscarNovos($feed);

        if ($artigos) {
            $this->getArtigoRepository()->salvarVarios($artigos);
        }
    }
}
