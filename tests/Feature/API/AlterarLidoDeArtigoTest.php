<?php

namespace Tests\Feature\API;

use Tests\TestCase;
// use App\Models\Feed as FeedModel;
use App\Models\Artigo as ArtigoModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AlterarLidoDeArtigoTest extends TestCase
{
    use RefreshDatabase;

    public function test_Api_Deve_Alterar_Artigo_Para_Lido_Com_Sucesso()
    {
        $artigo = factory(ArtigoModel::class, 1)->create([
            'titulo' => 'Primeiro Artigo',
            'descricao' => 'Este é o primeiro artigo',
            'link' => 'https://brunoviana.dev/primeiro-artigo',
            'autor' => 'Bruno Viana',
            'data_publicacao' => '2020-01-01',
            'lido' => 0,
            'feed_id' => 1,
        ])->first();

        $response = $this->post('/api/artigos/'.$artigo->id.'/alterar-lido', [
            'lido' => 1
        ]);

        $response->assertStatus(200);

        $this->assertEquals(1, ArtigoModel::all()->first()->lido);
    }

    public function test_Api_Deve_Alterar_Artigo_Para_NAO_Lido_Com_Sucesso()
    {
        $artigo = factory(ArtigoModel::class, 1)->create([
            'titulo' => 'Primeiro Artigo',
            'descricao' => 'Este é o primeiro artigo',
            'link' => 'https://brunoviana.dev/primeiro-artigo',
            'autor' => 'Bruno Viana',
            'data_publicacao' => '2020-01-01',
            'lido' => 1,
            'feed_id' => 1,
        ])->first();

        $response = $this->post('/api/artigos/'.$artigo->id.'/alterar-lido', [
            'lido' => 0
        ]);

        $response->assertStatus(200);

        $this->assertEquals(0, ArtigoModel::all()->first()->lido);
    }
}
