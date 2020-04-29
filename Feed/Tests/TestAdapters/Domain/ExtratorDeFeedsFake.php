<?php

namespace Feed\Tests\TestAdapters\Domain;

use Feed\Domain\Entities\Feed;
use Feed\Domain\Interfaces\ExtratorDeFeedsInterface;

class ExtratoDeFeedsFake implements ExtratorDeFeedsInterface
{
    public function extrair(string $url) : array
    {
        if ($url == 'https://brunoviana.dev') {
            return [
                Feed::novo('Blog do Bruno', 'https://brunoviana.dev/rss.xml')
            ];
        }

        return [];
    }
}
