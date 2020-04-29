<?php

namespace Feed\Tests\App\UseCases;

use Feed\Domain\Entities\Feed;
use Feed\Domain\Entities\Artigo;

use Feed\App\UseCases\SincronizarFeed;
use Feed\App\Requests\SincronizarFeedRequest;

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
        // $this->expectException(FeedNaoEncontradoException::class);

        // $this->makeMock(FeedRepositoryInterface::class, function ($mock) {
        //     $mock->shouldReceive('buscar')
        //             ->with(1)
        //             ->andReturn();
        // });

        // $this->makeMock(AtualizarFeedRequest::class, function ($mock) {
        //     $mock->shouldReceive('feedId')
        //             ->andThrow(new FeedNaoEncontradoException());
        // });

        // $this->makeMock(BuscadorDeArtigosAdapterInterface::class);

        // $atualizarFeed = $this->getInstance(AtualizarFeed::class);

        // $atualizarFeed->executar();
    }

    public function assertListaDeArtigos($artigos)
    {
        // $this->assertInstanceOf(ArtigoList::class, $artigos);
        // $this->assertCount(1, $artigos);

        // $this->assertInstanceOf(Artigo::class, $artigos->primeiro());
        // $this->assertInstanceOf(Autor::class, $artigos->primeiro()->autor());
        // $this->assertInstanceOf(Data::class, $artigos->primeiro()->dataPublicacao());

        // $this->assertEquals('Meu primeiro artigo', $artigos->primeiro()->titulo());
        // $this->assertEquals('Neste artigo você verá como fiz meu primeiro artigo', $artigos->primeiro()->descricao());
        // $this->assertEquals('https://brunoviana.dev/primeiro-artigo', $artigos->primeiro()->link());
        // $this->assertEquals('Bruno Viana', $artigos->primeiro()->autor()->nome());
        // $this->assertEquals('2020-01-01', $artigos->primeiro()->dataPublicacao()->formatoPadrao());
    }

    public function criaMocksParaInjetarNaUseCase()
    {
        // $this->makeMock(FeedRepositoryInterface::class, function ($mock) {
        //     $mock->shouldReceive('dataDaUltimaAtualizacao')
        //             ->andReturn(
        //                 new Data()
        //             );

        //     $mock->shouldReceive('buscar')
        //             ->with(1)
        //             ->andReturn(
        //                 Feed::novo('Blod do Bruno', 'https://brunoviana.dev')
        //             );

        //     $mock->shouldReceive('save');
        // });

        // $this->makeMock(AtualizarFeedRequest::class, function ($mock) {
        //     $mock->shouldReceive('feedId')
        //             ->andReturn(1);
        // });

        // $this->makeMock(BuscadorDeArtigosAdapterInterface::class, function ($mock) {
        //     $mock->shouldReceive('buscar')
        //             ->andReturn([
        //                 [
        //                     'titulo' => 'Meu primeiro artigo',
        //                     'descricao' => 'Neste artigo você verá como fiz meu primeiro artigo',
        //                     'link' => 'https://brunoviana.dev/primeiro-artigo',
        //                     'autor' => 'Bruno Viana',
        //                     'data_publicacao' => '2020-01-01'
        //                 ]
        //             ]);
        // });
    }
}
