<?php

namespace Tests\Framework\Unit\Mappers;

use Domain\Feed\Entities\Feed;

use Framework\Mappers\FeedMapper;
use Framework\Models\Feed as FeedModel;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeedMapperTest extends TestCase
{
    use RefreshDatabase;

    public function test_FeedRepository_Deve_Mapear_Entidade_Com_Sucesso()
    {
        $feed = Feed::novo(
            'Blog do Bruno',
            'https://brunoviana.dev/rss.xml'
        );

        $feedModel = FeedMapper::criaModel($feed);

        $this->assertEquals('Blog do Bruno', $feedModel->titulo);
        $this->assertEquals('https://brunoviana.dev/rss.xml', $feedModel->link_rss);
    }

    public function test_FeedRepository_Deve_Retornar_Entitade_Corretamente()
    {
        $feedModel = new FeedModel();
        $feedModel->titulo = 'Blog do Bruno';
        $feedModel->link_rss = 'https://brunoviana.dev/rss.xml';

        $feed = FeedMapper::criaEntidade($feedModel);

        $this->assertEquals('Blog do Bruno', $feed->titulo());
        $this->assertEquals('https://brunoviana.dev/rss.xml', $feed->linkRss());
    }
}
