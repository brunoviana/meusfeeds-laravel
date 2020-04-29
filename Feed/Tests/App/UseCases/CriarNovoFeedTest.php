<?php

namespace Feed\Tests\App\UseCases;

use Feed\Domain\Entities\Feed;

use Feed\App\UseCases\CriarNovoFeed;
use Feed\App\Requests\CriarNovoFeedRequest;
use Feed\App\Responses\CriarNovoFeedResponse;

use Feed\Tests\TestAdapters\Domain\FeedRepositoryFake;
use Feed\Tests\TestAdapters\Domain\ArtigoRepositoryFake;
use Feed\Tests\TestAdapters\Domain\BuscadorDeArtigosFake;

use Tests\TestCase;

class CriarNovoFeedTest extends TestCase
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
        $criarNovoFeed = new CriarNovoFeed(
            new CriarNovoFeedRequest(
                'Blog do Bruno',
                'https://brunoviana.dev/rss.xml'
            ),
            $this->feedRepositoryFake,
            $this->artigoRepositoryFake,
            $this->buscadorDeArtigosFake
        );
        
        $resposta = $criarNovoFeed->executar();

        $this->assertInstanceOf(CriarNovoFeedResponse::class, $resposta);
        $this->assertInstanceOf(Feed::class, $resposta->feed());
        $this->assertEquals(1, $resposta->feed()->id());
        $this->assertEquals('Blog do Bruno', $resposta->feed()->titulo());
        $this->assertEquals('https://brunoviana.dev/rss.xml', $resposta->feed()->linkRss());
    }

    public function test_Deve_Validar_Feed_Ja_Existente()
    {
        // $this->expectException(FeedJaExisteException::class);

        // $this->makeMock(FeedRepositoryInterface::class, function ($mock) {
        //     $mock->shouldReceive('buscarPeloLink')
        //             ->andReturn(
        //                 Feed::novo(
        //                     'Novo Feed',
        //                     'https://brunoviana.dev/rss.xml'
        //                 )
        //             );

        //     $mock->shouldNotReceive('save');
        // });

        // $this->makeMock(CriarNovoFeedRequest::class, function ($mock) {
        //     $mock->shouldReceive('titulo')
        //             ->andReturn('Novo Feed');

        //     $mock->shouldReceive('linkRss')
        //             ->andReturn('https://brunoviana.dev/rss.xml');
        // });

        // $criarFeed = $this->getInstance(CriarNovoFeed::class);
        // $criarFeed->executar();

        // $criarFeedRepetido = $this->getInstance(CriarNovoFeed::class);
        // $criarFeedRepetido->executar();
    }
}
