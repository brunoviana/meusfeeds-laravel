<?php

namespace App\Feed\Tests\UseCase;

use DMS\PHPUnitExtensions\ArraySubset\Assert;

use App\Feed\UseCases\DescobrirFeedsPelaUrl;
use App\Feed\Requests\DescobrirFeedsPelaUrlRequest;
use App\Feed\Responses\DescobrirFeedsPelaUrlResponse;
use App\Feed\Interfaces\Services\BuscadorDeFeedsServiceInterface;

trait DescobrirFeedsPelaUrlTest
{
    abstract protected function makeMock($class, $assertions);

    abstract protected function getInstance($class);

    public function test_Deve_Descobrir_Feeds_Pela_Url_Com_Sucesso()
    {
        $this->makeMock(DescobrirFeedsPelaUrlRequest::class, function ($mock) {
            $mock->shouldReceive('url')
                    ->andReturn('https://brunoviana.dev/');
        });

        $this->makeMock(BuscadorDeFeedsServiceInterface::class, function ($mock) {
            $mock->shouldReceive('buscar')
                    ->andReturn([
                        [
                            'titulo' => 'Blog do Bruno',
                            'link_rss' => 'https://brunoviana.dev/',
                            'descricao' => 'Este é meu blog',
                            'ultimos_artigos' => [
                                'Artigo 1',
                                'Artigo 2',
                                'Artigo 3',
                            ],
                        ]
                    ]);
        });

        $descobrirFeeds = $this->getInstance(DescobrirFeedsPelaUrl::class);

        $response = $descobrirFeeds->executar();

        $this->assertInstanceOf(DescobrirFeedsPelaUrlResponse::class, $response);
        $this->assertIsArray($response->feeds());
        Assert::assertArraySubset([
            'titulo' => 'Blog do Bruno',
            'link_rss' => 'https://brunoviana.dev/',
            'descricao' => 'Este é meu blog',
            'ultimos_artigos' => [
                'Artigo 1',
                'Artigo 2',
                'Artigo 3',
            ],
        ], $response->feeds()[0]);
    }
}
