<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use App\Models\Feed as FeedModel;
use App\Models\Artigo as ArtigoModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RetornarArtigosTest extends TestCase
{
    use RefreshDatabase;

    public function test_Api_Deve_Retornar_Todos_Os_Artigos_De_Um_Feed_Com_Sucesso()
    {
        $feedModel = factory(FeedModel::class)->create([
            'titulo' => 'Blog do Bruno',
            'link_rss' => 'https://brunoviana.dev/rss.xml'
        ])->first();

        factory(ArtigoModel::class, 1)->create([
            'titulo' => 'Primeiro Artigo',
            'descricao' => 'Este é o primeiro artigo',
            'link' => 'https://brunoviana.dev/primeiro-artigo',
            'autor' => 'Bruno Viana',
            'data_publicacao' => '2020-01-01',
            'lido' => 0,
            'feed_id' => $feedModel->id,
        ]);

        factory(ArtigoModel::class, 1)->create([
            'titulo' => 'Segundo Artigo',
            'descricao' => 'Este é o segundo artigo',
            'link' => 'https://brunoviana.dev/segundo-artigo',
            'autor' => 'Bruno Viana',
            'data_publicacao' => '2020-01-02',
            'lido' => 0,
            'feed_id' => $feedModel->id,
        ]);

        $response = $this->get('/api/feeds/'.$feedModel->id.'/artigos');

        $response->assertStatus(200)
                ->assertJsonFragment([
                    'titulo' => 'Primeiro Artigo',
                    'descricao' => 'Este é o primeiro artigo',
                    'link' => 'https://brunoviana.dev/primeiro-artigo',
                    'data_publicacao' => '2020-01-01T00:00:00.000000Z',
                    'autor' => 'Bruno Viana',
                    'lido' => '0',
                    'feed_id' => '1'
                ])
                ->assertJsonFragment([
                    'titulo' => 'Segundo Artigo',
                    'descricao' => 'Este é o segundo artigo',
                    'link' => 'https://brunoviana.dev/segundo-artigo',
                    'autor' => 'Bruno Viana',
                    'data_publicacao' => '2020-01-02T00:00:00.000000Z',
                    'lido' => '0',
                    'feed_id' => '1',
                ]);
    }
}
