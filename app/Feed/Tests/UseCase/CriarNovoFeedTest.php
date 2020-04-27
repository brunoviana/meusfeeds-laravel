<?php

namespace App\Feed\Tests\UseCase;

use Domain\Feed\Interfaces\Repositories\FeedRepositoryInterface;
use Domain\Feed\Interfaces\Services\BuscadorDeArtigosServiceInterface;
use Domain\Feed\Entities\Feed;

use App\Feed\UseCases\CriarNovoFeed;
use App\Feed\Requests\CriarNovoFeedRequest;
use App\Feed\Responses\CriarNovoFeedResponse;
use App\Feed\Exceptions\FeedJaExisteException;

trait CriarNovoFeedTest
{
    abstract protected function makeMock($class, $assertions=null);

    abstract protected function getInstance($class);
    
    public function test_Deve_Criar_Novo_Feed_Com_Sucesso()
    {
        $this->makeMock(BuscadorDeArtigosServiceInterface::class);
        
        $this->makeMock(FeedRepositoryInterface::class, function ($mock) {
            $mock->shouldReceive('buscarPeloLink')
                    ->andReturn(null);

            $mock->shouldReceive('save')
                    ->andReturn(1);
        });

        $this->makeMock(CriarNovoFeedRequest::class, function ($mock) {
            $mock->shouldReceive('titulo')
                    ->andReturn('Novo Feed');

            $mock->shouldReceive('linkRss')
                    ->andReturn('https://brunoviana.dev/rss.xml');
        });

        $criarFeed = $this->getInstance(CriarNovoFeed::class);

        $response = $criarFeed->executar();

        $this->assertInstanceOf(CriarNovoFeedResponse::class, $response);
        $this->assertInstanceOf(Feed::class, $response->feed());
        $this->assertEquals(1, $response->feed()->id());
    }

    public function test_Deve_Validar_Feed_Ja_Existente()
    {
        $this->expectException(FeedJaExisteException::class);

        $buscadorDeArtigosMock = $this->makeMock(BuscadorDeArtigosServiceInterface::class);

        $this->makeMock(FeedRepositoryInterface::class, function ($mock) use ($buscadorDeArtigosMock) {
            $mock->shouldReceive('buscarPeloLink')
                    ->andReturn(
                        new Feed(
                            'Novo Feed',
                            'https://brunoviana.dev/rss.xml',
                            $buscadorDeArtigosMock
                        )
                    );

            $mock->shouldNotReceive('save');
        });

        $this->makeMock(CriarNovoFeedRequest::class, function ($mock) {
            $mock->shouldReceive('titulo')
                    ->andReturn('Novo Feed');

            $mock->shouldReceive('linkRss')
                    ->andReturn('https://brunoviana.dev/rss.xml');
        });

        $criarFeed = $this->getInstance(CriarNovoFeed::class);
        $criarFeed->executar();

        $criarFeedRepetido = $this->getInstance(CriarNovoFeed::class);
        $criarFeedRepetido->executar();
    }
}
