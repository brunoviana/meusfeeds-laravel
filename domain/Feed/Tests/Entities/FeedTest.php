<?php

namespace Domain\Feed\Tests\Entities;

use Domain\Feed\Entities\Feed;
use Domain\Feed\ValueObjects\ArtigoList;
use Domain\Feed\ValueObjects\Data;

trait FeedTest
{
    public function test_Novo_Feed_Deve_Comecar_Com_Zero_Artigos()
    {
        $feed = Feed::novo(
            'Blog do Bruno',
            'https://brunoviana.dev'
        );
        
        $this->assertCount(0, $feed->artigos());
        $this->assertInstanceOf(ArtigoList::class, $feed->artigos());
    }
}
