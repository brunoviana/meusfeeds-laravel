<?php

namespace Feed\Domain\Services;

use Feed\Domain\Entities\Feed;
use Feed\Domain\Exceptions\FeedJaExisteException;

class FeedService extends Service
{
    public function criarNovoFeed(string $titulo, string $linkRss)
    {
        $feedEncontrado = $this->getFeedRepository()->buscarPeloLink(
            $linkRss
        );

        if ($feedEncontrado) {
            throw new FeedJaExisteException('Este feed já está cadastrado');
        }

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
