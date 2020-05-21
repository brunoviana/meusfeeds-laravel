<?php

namespace Feed\Tests\Domain\Services;

use Tests\TestCase;
use Feed\Domain\Entities\Feed;
use Feed\Domain\Entities\Artigo;
use Feed\Domain\Services\FeedService;

use Feed\Domain\Exceptions\FeedJaExisteException;
use Feed\Tests\TestAdapters\Domain\FeedRepositoryFake;
use Feed\Tests\TestAdapters\Domain\ArtigoRepositoryFake;

use Feed\Tests\TestAdapters\Domain\BuscadorDeArtigosFake;

class FeedServiceTest extends TestCase
{
    protected $feedRepositoryFake;

    protected $artigoRepositoryFake;

    protected $buscadorDeArtigos;

    public function setUp() : void
    {
        $this->feedRepositoryFake = new FeedRepositoryFake();
        $this->artigoRepositoryFake = new ArtigoRepositoryFake();
        $this->buscadorDeArtigosFake = new BuscadorDeArtigosFake();
    }

    public function test_Deve_Criar_Novo_Feed_Com_Sucesso()
    {
        $feedService = new FeedService();

        $feedService->setBuscadorDeArtigos($this->buscadorDeArtigosFake);
        $feedService->setFeedRepository($this->feedRepositoryFake);
        $feedService->setArtigoRepository($this->artigoRepositoryFake);

        $feed = $feedService->criarNovoFeed(
            'Blog do Bruno',
            'https://brunoviana.dev/rss.xml'
        );

        $this->assertInstanceOf(Feed::class, $feed);
        $this->assertEquals(1, $feed->id());
        $this->assertEquals('Blog do Bruno', $feed->titulo());
        $this->assertEquals('https://brunoviana.dev/rss.xml', $feed->linkRss());
    }

    public function test_Deve_Falhar_Se_Feed_Ja_Existir()
    {
        $this->expectException(FeedJaExisteException::class);

        $feedService = new FeedService();

        $feedService->setBuscadorDeArtigos($this->buscadorDeArtigosFake);
        $feedService->setFeedRepository($this->feedRepositoryFake);
        $feedService->setArtigoRepository($this->artigoRepositoryFake);

        $feedService->criarNovoFeed(
            'Blog do Bruno',
            'https://brunoviana.dev/rss.xml'
        );

        $feedService->criarNovoFeed(
            'Blog do Bruno',
            'https://brunoviana.dev/rss.xml'
        );
    }

    public function test_Deve_Pegar_Todos_Os_Artigos_Quando_Adicionar_Novo_Feed()
    {
        $feedService = new FeedService();

        $feedService->setBuscadorDeArtigos($this->buscadorDeArtigosFake);
        $feedService->setFeedRepository($this->feedRepositoryFake);
        $feedService->setArtigoRepository($this->artigoRepositoryFake);

        $feedService->criarNovoFeed(
            'Blog do Bruno',
            'https://brunoviana.dev/rss.xml'
        );

        $artigos = $this->artigoRepositoryFake->todos();

        $this->assertIsArray($artigos);
        $this->assertCount(3, $artigos);
        $this->assertInstanceOf(Artigo::class, $artigos[0]);
        $this->assertInstanceOf(Artigo::class, $artigos[1]);
        $this->assertInstanceOf(Artigo::class, $artigos[2]);
    }

    public function test_Deve_Sincronizar_Novos_Artigos()
    {
        $feed = Feed::novo(
            'Blog do Bruno',
            'https://brunoviana.dev/rss.xml'
        );

        $feedService = new FeedService();

        $feedService->setBuscadorDeArtigos($this->buscadorDeArtigosFake);
        $feedService->setArtigoRepository($this->artigoRepositoryFake);

        $feedService->sincronizarNovosArtigos($feed);

        $artigos = $this->artigoRepositoryFake->todos();

        $this->assertIsArray($artigos);
        $this->assertCount(1, $artigos);
        $this->assertInstanceOf(Artigo::class, $artigos[0]);
    }
}
