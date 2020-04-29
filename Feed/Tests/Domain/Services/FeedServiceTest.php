<?php

namespace Feed\Tests\Domain\Services;

use Feed\Domain\Entities\Feed;
use Feed\Domain\Entities\Artigo;
use Feed\Domain\Services\FeedService;
use Feed\Domain\Exceptions\FeedJaExisteException;
use Feed\Tests\TestAdapters\Domain\ExtratoDeFeedsFake;
use Feed\Tests\TestAdapters\Domain\FeedRepositoryFake;
use Feed\Tests\TestAdapters\Domain\ArtigoRepositoryFake;
use Feed\Tests\TestAdapters\Domain\BuscadorDeArtigosFake;

use Tests\TestCase;

class FeedServiceTest extends TestCase
{
    protected $extratorDeFeedFake;
    
    protected $feedRepositoryFake;
    
    protected $artigoRepositoryFake;
    
    protected $buscadorDeArtigos;

    public function setUp() : void
    {
        $this->extratorDeFeedFake = new ExtratoDeFeedsFake();
        $this->feedRepositoryFake = new FeedRepositoryFake();
        $this->artigoRepositoryFake = new ArtigoRepositoryFake();
        $this->buscadorDeArtigosFake = new BuscadorDeArtigosFake();
    }

    public function test_Deve_Buscar_Feeds_Disponiveis_Da_Url()
    {
        $url = 'https://brunoviana.dev';

        $feedService = new FeedService();
        $feedService->setExtratorDeFeeds($this->extratorDeFeedFake);

        $feeds = $feedService->procurarFeedsPelaUrl($url);

        $this->assertIsArray($feeds);
        $this->assertCount(1, $feeds);
        $this->assertInstanceOf(Feed::class, $feeds[0]);
    }

    public function test_Deve_Retornar_Array_Vazio_Se_Nao_Achar_Nada()
    {
        $url = 'https://brunoviana.dev.nao.achar.nada';

        $feedService = new FeedService();
        $feedService->setExtratorDeFeeds($this->extratorDeFeedFake);

        $feeds = $feedService->procurarFeedsPelaUrl($url);

        $this->assertIsArray($feeds);
        $this->assertCount(0, $feeds);
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