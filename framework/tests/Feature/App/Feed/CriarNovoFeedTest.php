<?php

namespace Tests\Feature\App\Feed;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

use App\Feed\UseCases\CriarNovoFeed;
use App\Feed\Requests\CriarNovoFeedRequest;
use App\Feed\Responses\CriarNovoFeedResponse;
use App\Feed\Exceptions\FeedJaExisteException;
use App\Feed\Interfaces\Repositories\FeedRepositoryInterface;

use Domain\Feed\Entities\Feed;

class CriarNovoFeedTest extends TestCase
{
    public function test_Deve_Criar_Novo_Feed_Com_Sucesso()
    {
        $this->mock(FeedRepositoryInterface::class, function ($mock) {
            $mock->shouldReceive('buscarPeloLink')
                    ->andReturn(null);

            $mock->shouldReceive('save')
                    ->andReturn(1);
        });

        $this->mock(CriarNovoFeedRequest::class, function ($mock) {
            $mock->shouldReceive('titulo')
                    ->andReturn('Novo Feed');

            $mock->shouldReceive('linkRss')
                    ->andReturn('https://brunoviana.dev/rss.xml');
        });

        $criarFeed = app(CriarNovoFeed::class);

        $response = $criarFeed->executar();

        $this->assertInstanceOf(CriarNovoFeedResponse::class, $response);
        $this->assertInstanceOf(Feed::class, $response->feed());
        $this->assertEquals(1, $response->feed()->id());
    }

    public function test_Deve_Validar_Feed_Ja_Existente()
    {
        $this->expectException(FeedJaExisteException::class);

        $this->mock(FeedRepositoryInterface::class, function ($mock) {
            $mock->shouldReceive('buscarPeloLink')
                    ->andReturn(new Feed('Novo Feed', 'https://brunoviana.dev/rss.xml'));

            $mock->shouldNotReceive('save');
        });

        $this->mock(CriarNovoFeedRequest::class, function ($mock) {
            $mock->shouldReceive('titulo')
                    ->andReturn('Novo Feed');

            $mock->shouldReceive('linkRss')
                    ->andReturn('https://brunoviana.dev/rss.xml');
        });

        $criarFeed = app(CriarNovoFeed::class);
        $criarFeed->executar();

        $criarFeedRepetido = app(CriarNovoFeed::class);
        $criarFeedRepetido->executar();
    }
}
