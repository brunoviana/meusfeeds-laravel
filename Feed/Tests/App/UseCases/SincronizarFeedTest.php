<?php

namespace Feed\Tests\App\UseCases;

use Tests\TestCase;
use Feed\Domain\Entities\Feed;

use Feed\Domain\Entities\Artigo;
use Feed\App\UseCases\SincronizarFeed;

use Feed\App\Requests\SincronizarFeedRequest;
use Feed\Tests\TestAdapters\Domain\ArtigoRepositoryFake;

use Feed\Tests\TestAdapters\Domain\BuscadorDeArtigosFake;

class SincronizarFeedTest extends TestCase
{
    protected $extratorDeFeedFake;

    protected $feedRepositoryFake;

    protected $artigoRepositoryFake;

    protected $buscadorDeArtigos;

    public function setUp() : void
    {
        $this->artigoRepositoryFake = new ArtigoRepositoryFake();
        $this->buscadorDeArtigosFake = new BuscadorDeArtigosFake();
    }

    public function test_Deve_Atualizar_Feed_Com_Sucesso()
    {
        $feed = Feed::novo(
            'Blog do Bruno',
            'https://brunoviana.dev/rss.xml'
        );

        $sincronizaFeed = new SincronizarFeed(
            new SincronizarFeedRequest(
                $feed
            ),
            $this->artigoRepositoryFake,
            $this->buscadorDeArtigosFake
        );

        $sincronizaFeed->executar();

        $artigos = $this->artigoRepositoryFake->todos();

        $this->assertIsArray($artigos);
        $this->assertCount(1, $artigos);
        $this->assertInstanceOf(Artigo::class, $artigos[0]);
    }
}
