<?php

namespace Feed\Tests\App\UseCases;

use Feed\Domain\Entities\Feed;

use Feed\App\UseCases\DescobrirFeedsPelaUrl;
use Feed\App\Requests\DescobrirFeedsPelaUrlRequest;
use Feed\App\Responses\DescobrirFeedsPelaUrlResponse;

use Feed\Tests\TestAdapters\Domain\ExtratoDeFeedsFake;

use Tests\TestCase;

class DescobrirFeedsPelaUrlTest extends TestCase
{
    protected $extratorDeFeedFake;

    public function setUp() : void
    {
        $this->extratorDeFeedFake = new ExtratoDeFeedsFake();
    }

    public function test_Deve_Descobrir_Feeds_Pela_Url_Com_Sucesso()
    {
        $descobrirFeeds = new DescobrirFeedsPelaUrl(
            new DescobrirFeedsPelaUrlRequest('https://brunoviana.dev'),
            $this->extratorDeFeedFake
        );

        $descobrirFeeds->executar();

        $response = $descobrirFeeds->executar();

        $this->assertInstanceOf(DescobrirFeedsPelaUrlResponse::class, $response);
        $this->assertIsArray($response->feeds());
        $this->assertCount(1, $response->feeds());
        $this->assertInstanceOf(Feed::class, $response->feeds()[0]);
    }
}
