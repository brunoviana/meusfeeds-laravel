<?php

namespace Tests\Framework\Unit\Framework\Adapters\Feed\Services\BuscadorDeFeedsService;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

use Framework\Adapters\Feed\Services\BuscadorDeFeedsService\FeedIoAdapter;

class FeedIoAdapterTest extends TestCase
{
    use RefreshDatabase;

    public function test_FeedIoAdapter_Deve_Buscar_Feeds_Com_Sucesso()
    {
        $this->criaFeedIoMocks();

        $feedAdapter = app(FeedIoAdapter::class);

        $result = $feedAdapter->buscar('https://brunoviana.dev');

        $this->assertCount(1, $result);
        $this->assertArraySubset([
            'titulo' => 'Blog do Bruno',
            'link_rss' => 'https://brunoviana.dev',
            'descricao' => 'Este é o meu blog',
            'ultimos_artigos' => [
                'Artigo 1',
                'Artigo 2',
                'Artigo 3',
            ]
        ], $result[0]);
    }

    public function test_FeedIoAdapter_Deve_Retornar_Apenas_3_Artigos()
    {
        $this->criaFeedIoMocks([
            'feed_itens' => [
                'Artigo 1',
                'Artigo 2',
                'Artigo 3',
                'Artigo 4',
                'Artigo 5',
            ]
        ]);

        $feedAdapter = app(FeedIoAdapter::class);

        $result = $feedAdapter->buscar('https://brunoviana.dev');

        $this->assertCount(3, $result[0]['ultimos_artigos']);
    }

    public function criaFeedIoMocks($params = [])
    {
        $params = array_merge([
            'feed_rss' => '/rss.xml',
            'feed_title' => 'Blog do Bruno',
            'feed_link' => 'https://brunoviana.dev',
            'feed_description' => 'Este é o meu blog',
            'feed_itens' => [
                'Artigo 1',
                'Artigo 2',
                'Artigo 3',
            ]
        ], $params);

        $artigoFeedMock = app(\FeedIo\Feed::class);

        foreach ($params['feed_itens'] as $feedItem) {
            $artigoMock = $this->mock(\FeedIo\Feed\Item::class, function ($mock) use ($feedItem) {
                $mock->shouldReceive('getTitle')->andReturn($feedItem);
            });

            $artigoFeedMock->add($artigoMock);
        }

        $feedResultMock = $this->mock(\FeedIo\FeedInterface::class, function ($mock) use ($params) {
            $mock->shouldReceive('getTitle')->andReturn($params['feed_title']);
            $mock->shouldReceive('getLink')->andReturn($params['feed_link']);
            $mock->shouldReceive('getDescription')->andReturn($params['feed_description']);
        });

        $readResult = $this->mock(\FeedIo\Reader\Result::class, function ($mock) use ($artigoFeedMock, $feedResultMock) {
            $mock->shouldReceive('getFeed')->andReturn(
                $artigoFeedMock,
                $feedResultMock
            );
        });

        $this->mock(\FeedIo\FeedIo::class, function ($mock) use ($readResult, $params) {
            $mock->shouldReceive('discover')->andReturn([
                $params['feed_rss']
            ]);

            $mock->shouldReceive('read')->andReturn($readResult);
        });
    }
}
