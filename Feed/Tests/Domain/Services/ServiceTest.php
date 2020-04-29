<?php

namespace Feed\Tests\Domain\Services;

use Feed\Domain\Services\Service;
use Feed\Tests\TestAdapters\Domain\ExtratoDeFeedsFake;
use Feed\Tests\TestAdapters\Domain\FeedRepositoryFake;
use Feed\Tests\TestAdapters\Domain\ArtigoRepositoryFake;
use Feed\Tests\TestAdapters\Domain\BuscadorDeArtigosFake;

use Tests\TestCase;

class ServiceTest extends TestCase
{
    protected $extratorDeFeedFake;
    
    protected $feedRepositoryFake;
    
    protected $artigoRepositoryFake;
    
    protected $buscadorDeArtigos;

    public function setUp() : void
    {
        $this->extratorDeFeedFake = new ExtratoDeFeedsFake();
        $this->feedRepositoryFake = new FeedRepositoryFake();
        $this->buscadorDeArtigos = new BuscadorDeArtigosFake();
        $this->artigoRepositoryFake = new ArtigoRepositoryFake();
    }

    public function test_Deve_Setar_Extrator_De_Feed_Com_Sucesso()
    {
        $service = new Service();
        $service->setExtratorDeFeeds($this->extratorDeFeedFake);

        $this->assertInstanceOf(ExtratoDeFeedsFake::class, $service->getExtratorDeFeeds());
    }

    public function test_Deve_Retornar_Erro_Se_Nao_Tiver_Extrator_De_Feed()
    {
        $this->expectException(\RuntimeException::class);

        $service = new Service();
        $service->getExtratorDeFeeds();
    }

    public function test_Deve_Setar_FeedRepository_Com_Sucesso()
    {
        $service = new Service();
        $service->setFeedRepository($this->feedRepositoryFake);

        $this->assertInstanceOf(FeedRepositoryFake::class, $service->getFeedRepository());
    }

    public function test_Deve_Retornar_Erro_Se_Nao_Tiver_FeedRepository()
    {
        $this->expectException(\RuntimeException::class);

        $service = new Service();
        $service->getFeedRepository();
    }

    public function test_Deve_Setar_ArtigoRepository_Com_Sucesso()
    {
        $service = new Service();
        $service->setArtigoRepository($this->artigoRepositoryFake);

        $this->assertInstanceOf(ArtigoRepositoryFake::class, $service->getArtigoRepository());
    }

    public function test_Deve_Retornar_Erro_Se_Nao_Tiver_ArtigoRepository()
    {
        $this->expectException(\RuntimeException::class);

        $service = new Service();
        $service->getArtigoRepository();
    }

    public function test_Deve_Setar_BuscadorDeArtigos_Com_Sucesso()
    {
        $service = new Service();
        $service->setBuscadorDeArtigos($this->buscadorDeArtigos);

        $this->assertInstanceOf(BuscadorDeArtigosFake::class, $service->getBuscadorDeArtigos());
    }

    public function test_Deve_Retornar_Erro_Se_Nao_Tiver_BuscadorDeArtigos()
    {
        $this->expectException(\RuntimeException::class);

        $service = new Service();
        $service->getBuscadorDeArtigos();
    }
}