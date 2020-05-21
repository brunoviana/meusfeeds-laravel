<?php

namespace Feed\Tests\Domain\Entities;

use Tests\TestCase;

use Feed\Domain\Entities\Feed;

class FeedTest extends TestCase
{
    public function test_Novo_Feed_Deve_Comecar_Com_Id_Zero()
    {
        $feed = Feed::novo(
            'Blog do Bruno',
            'https://brunoviana.dev/rss.xml'
        );

        $this->assertEquals(0, $feed->id());
    }

    public function test_Novo_Feed_Deve_Inserir_Id_Com_Sucesso()
    {
        $feed = Feed::novo(
            'Blog do Bruno',
            'https://brunoviana.dev/rss.xml'
        );

        $feed->id(1);

        $this->assertEquals(1, $feed->id());
    }

    public function test_Deve_Falhar_Setar_Id_Do_Feed_Se_Ja_Tiver_Id()
    {
        $this->expectException(\RuntimeException::class);

        $feed = Feed::novo(
            'Blog do Bruno',
            'https://brunoviana.dev/rss.xml'
        );

        $feed->id(1);
        $feed->id(2);
    }

    public function test_Feed_Deve_Retornar_Titulo_Correto()
    {
        $feed = Feed::novo(
            'Blog do Bruno',
            'https://brunoviana.dev/rss.xml'
        );

        $this->assertEquals('Blog do Bruno', $feed->titulo());
    }

    public function test_Feed_Deve_Retornar_Link_Rss_Correto()
    {
        $feed = Feed::novo(
            'Blog do Bruno',
            'https://brunoviana.dev/rss.xml'
        );

        $this->assertEquals('https://brunoviana.dev/rss.xml', $feed->linkRss());
    }
}
