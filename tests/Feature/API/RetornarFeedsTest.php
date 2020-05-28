<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use App\Models\Feed as FeedModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RetornarFeedsTest extends TestCase
{
    use RefreshDatabase;

    public function test_Api_Deve_Retornar_Todos_Os_Feeds_Com_Sucesso()
    {
        factory(FeedModel::class)->create([
            'titulo' => 'Blog do Bruno',
            'link_rss' => 'https://brunoviana.dev/rss.xml'
        ]);

        $response = $this->get('/api/feeds');

        $response->assertStatus(200)
                ->assertJsonFragment([
                    'id' => 1,
                    'titulo' => 'Blog do Bruno',
                    'link_rss' => 'https://brunoviana.dev/rss.xml'
                ]);
    }

    public function test_Api_Deve_Retornar_Feed_Com_Sucesso()
    {
        factory(FeedModel::class)->create([
            'titulo' => 'Blog do Bruno',
            'link_rss' => 'https://brunoviana.dev/rss.xml'
        ]);

        $response = $this->get('/api/feeds/1');

        $response->assertStatus(200)
                ->assertJsonFragment([
                    'id' => 1,
                    'titulo' => 'Blog do Bruno',
                    'link_rss' => 'https://brunoviana.dev/rss.xml'
                ]);
    }
}
