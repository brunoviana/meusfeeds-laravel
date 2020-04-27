<?php

namespace Tests\Unit\Framework\Models;

use Domain\Feed\Entities\Feed;
use Domain\Feed\Interfaces\Services\BuscadorDeArtigosServiceInterface;

use Framework\Models\Feed as FeedModel;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedTest extends TestCase
{
    use RefreshDatabase;

    public function test_FeedModel_Deve_Mapear_Entidade_Com_Sucesso()
    {
        $feed = new Feed(
            'Blog do Bruno',
            'https://brunoviana.dev/rss.xml',
            $this->makeMock(BuscadorDeArtigosServiceInterface::class)
        );

        $feedModel = new FeedModel();
        $feedModel->map($feed);

        $this->assertEquals('Blog do Bruno', $feedModel->titulo);
        $this->assertEquals('https://brunoviana.dev/rss.xml', $feedModel->link_rss);
    }

    public function test_FeedModel_Deve_Retornar_Entitade_Corretamente()
    {
        $feedModel = new FeedModel();
        $feedModel->titulo = 'Blog do Bruno';
        $feedModel->link_rss = 'https://brunoviana.dev/rss.xml';

        $feed = $feedModel->entity();

        $this->assertEquals('Blog do Bruno', $feed->titulo());
        $this->assertEquals('https://brunoviana.dev/rss.xml', $feed->linkRss());
    }
}
