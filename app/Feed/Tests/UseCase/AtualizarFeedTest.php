<?php

namespace App\Feed\Tests\UseCase;

use Domain\Feed\ValueObjects\ArtigoList;
use Domain\Feed\ValueObjects\Artigo;
use Domain\Feed\ValueObjects\Data;
use Domain\Feed\ValueObjects\Autor;
use Domain\Feed\Entities\Feed;
use Domain\Feed\Interfaces\Repositories\FeedRepositoryInterface;

use App\Feed\UseCases\AtualizarFeed;
use App\Feed\Requests\AtualizarFeedRequest;
use App\Feed\Exceptions\FeedNaoEncontradoException;
use App\Feed\Interfaces\Adapters\BuscadorDeArtigosAdapterInterface;

trait AtualizarFeedTest
{
    public function test_Deve_Atualizar_Feed_Com_Sucesso()
    {
        $this->criaMocksParaInjetarNaUseCase();

        $atualizarFeed = $this->getInstance(AtualizarFeed::class);

        $response = $atualizarFeed->executar();

        $feed = $response->feed();

        $this->assertListaDeArtigos($feed->artigos());
    }

    public function test_Deve_Falhar_Se_Feed_Nao_Existir()
    {
        $this->expectException(FeedNaoEncontradoException::class);

        $this->makeMock(FeedRepositoryInterface::class, function ($mock) {
            $mock->shouldReceive('buscar')
                    ->with(1)
                    ->andReturn();
        });

        $this->makeMock(AtualizarFeedRequest::class, function ($mock) {
            $mock->shouldReceive('feedId')
                    ->andThrow(new FeedNaoEncontradoException());
        });

        $this->makeMock(BuscadorDeArtigosAdapterInterface::class);

        $atualizarFeed = $this->getInstance(AtualizarFeed::class);

        $atualizarFeed->executar();
    }

    public function assertListaDeArtigos($artigos)
    {
        $this->assertInstanceOf(ArtigoList::class, $artigos);
        $this->assertCount(1, $artigos);

        $this->assertInstanceOf(Artigo::class, $artigos->primeiro());
        $this->assertInstanceOf(Autor::class, $artigos->primeiro()->autor());
        $this->assertInstanceOf(Data::class, $artigos->primeiro()->dataPublicacao());

        $this->assertEquals('Meu primeiro artigo', $artigos->primeiro()->titulo());
        $this->assertEquals('Neste artigo você verá como fiz meu primeiro artigo', $artigos->primeiro()->descricao());
        $this->assertEquals('https://brunoviana.dev/primeiro-artigo', $artigos->primeiro()->link());
        $this->assertEquals('Bruno Viana', $artigos->primeiro()->autor()->nome());
        $this->assertEquals('2020-01-01', $artigos->primeiro()->dataPublicacao()->formatoPadrao());
    }

    public function criaMocksParaInjetarNaUseCase()
    {
        $this->makeMock(FeedRepositoryInterface::class, function ($mock) {
            $mock->shouldReceive('buscar')
                    ->with(1)
                    ->andReturn(
                        Feed::novo('Blod do Bruno', 'https://brunoviana.dev')
                    );

            $mock->shouldReceive('save');
        });

        $this->makeMock(AtualizarFeedRequest::class, function ($mock) {
            $mock->shouldReceive('feedId')
                    ->andReturn(1);
        });

        $this->makeMock(BuscadorDeArtigosAdapterInterface::class, function ($mock) {
            $mock->shouldReceive('buscar')
                    ->andReturn([
                        [
                            'titulo' => 'Meu primeiro artigo',
                            'descricao' => 'Neste artigo você verá como fiz meu primeiro artigo',
                            'link' => 'https://brunoviana.dev/primeiro-artigo',
                            'autor' => 'Bruno Viana',
                            'data_publicacao' => '2020-01-01'
                        ]
                    ]);
        });
    }
}
