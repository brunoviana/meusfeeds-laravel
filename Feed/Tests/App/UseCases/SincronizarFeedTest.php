<?php

namespace Feed\Tests\App\UseCases;

use Feed\Domain\Entities\Feed;
use Feed\Domain\Entities\Artigo;

use Feed\App\UseCases\SincronizarFeed;
use Feed\App\Requests\SincronizarFeedRequest;
use Feed\App\Exceptions\FeedNaoEncontradoException;

use Feed\Tests\TestAdapters\Domain\FeedRepositoryFake;
use Feed\Tests\TestAdapters\Domain\ArtigoRepositoryFake;
use Feed\Tests\TestAdapters\Domain\BuscadorDeArtigosFake;

use Tests\TestCase;

class SincronizarFeedTest extends TestCase
{
    protected $extratorDeFeedFake;
    
    protected $feedRepositoryFake;
    
    protected $artigoRepositoryFake;
    
    protected $buscadorDeArtigos;

    public function setUp() : void
    {
        $this->feedRepositoryFake = new FeedRepositoryFake();
        $this->artigoRepositoryFake = new ArtigoRepositoryFake();
        $this->buscadorDeArtigosFake = new BuscadorDeArtigosFake();
    }

    public function test_Deve_Atualizar_Feed_Com_Sucesso()
    {
        $feed = Feed::novo(
            'Blog do Bruno',
            'https://brunoviana.dev/rss.xml'
        );

        $this->feedRepositoryFake->salvar($feed);

        $sincronizaFeed = new SincronizarFeed(
            new SincronizarFeedRequest(
                $feed->id()
            ),
            $this->feedRepositoryFake,
            $this->artigoRepositoryFake,
            $this->buscadorDeArtigosFake
        );

        $sincronizaFeed->executar();

        $artigos = $this->artigoRepositoryFake->todos();

        $this->assertIsArray($artigos);
        $this->assertCount(1, $artigos);
        $this->assertInstanceOf(Artigo::class, $artigos[0]);
    }

    public function test_Deve_Falhar_Se_Feed_Nao_Existir()
    {
        $this->expectException(FeedNaoEncontradoException::class);

        $sincronizaFeed = new SincronizarFeed(
            new SincronizarFeedRequest(1),
            $this->feedRepositoryFake,
            $this->artigoRepositoryFake,
            $this->buscadorDeArtigosFake
        );

        $sincronizaFeed->executar();
    }
}
