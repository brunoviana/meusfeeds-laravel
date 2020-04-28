<?php

namespace Tests\Framework\Unit\Framework\Adapters\Repositories;

use Domain\Feed\Entities\Feed;

use Framework\Adapters\Feed\Repositories\FeedRepositoryAdapter;
use Framework\Models\Feed as FeedModel;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedRepositoryAdapterTest extends TestCase
{
    use RefreshDatabase;

    public function test_FeedRepository_Deve_Feed_Buscar_Pelo_Link()
    {
        factory(FeedModel::class, 1)->create([
            'titulo' => 'Blog do Bruno',
            'link_rss' => 'https://brunoviana.dev/rss.xml'
        ]);

        $repository = new FeedRepositoryAdapter();
        $feed = $repository->buscarPeloLink('https://brunoviana.dev/rss.xml');

        $this->assertInstanceOf(Feed::class, $feed);
        $this->assertEquals('Blog do Bruno', $feed->titulo());
    }

    public function test_FeedRepository_Deve_Salvar_E_Retornar_Response()
    {
        $feed = Feed::novo(
            'Blog do Bruno',
            'https://brunoviana.dev/rss.xml'
        );

        $repository = new FeedRepositoryAdapter();
        $id = $repository->save($feed);

        $this->assertEquals(1, $id);
        $this->assertCount(1, FeedModel::all());
    }
}
