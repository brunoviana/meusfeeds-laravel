<?php

namespace Feed\Tests\TestAdapters\Domain;

use Feed\Domain\Entities\Feed;
use Feed\Domain\Entities\Artigo;
use Feed\Domain\Interfaces\BuscadorDeArtigosInterface;

class BuscadorDeArtigosFake implements BuscadorDeArtigosInterface
{
    public function buscarTodos(Feed $feed) : array
    {
        if ($feed->linkRss() == 'https://brunoviana.dev/rss.xml') {
            return [
                Artigo::novo(),
                Artigo::novo(),
                Artigo::novo(),
            ];
        }

        return [];
    }

    public function buscarNovos(Feed $feed) : array
    {
        if ($feed->linkRss() == 'https://brunoviana.dev/rss.xml') {
            return [
                Artigo::novo(),
            ];
        }

        return [];
    }
}
