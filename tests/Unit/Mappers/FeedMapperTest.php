<?php

namespace Tests\Unit\Mappers;

use Tests\TestCase;

use MeusFeeds\Feeds\Domain\Entities\Feed;
use App\Mappers\FeedMapper;

use App\Models\Feed as FeedModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeedMapperTest extends TestCase
{
    use RefreshDatabase;

    public function test_FeedRepository_Deve_Mapear_Entidade_Com_Sucesso()
    {
        $feed = new Feed(
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
