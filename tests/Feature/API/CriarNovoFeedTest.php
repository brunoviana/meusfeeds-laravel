<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CriarNovoFeedTest extends TestCase
{
    use RefreshDatabase;

    public function test_Api_Deve_Criar_Feed_Com_Sucesso()
    {
        $params = [
            'titulo' => 'Blog do Bruno',
            'link_rss' => 'https://brunoviana.dev/rss.xml'
        ];

        $response = $this->post('/api/feeds', $params);

        $response->assertStatus(201)
                ->assertJsonFragment(array_merge($params, [
                    'id' => 1
                ]));
    }

    public function test_Api_Deve_Retornar_Erro_Se_Feed_Ja_Existir()
    {
        $params = [
            'titulo' => 'Blog do Bruno',
            'link_rss' => 'https://brunoviana.dev/rss.xml'
        ];

        $this->post('/api/feeds', $params);

        $response = $this->post('/api/feeds', $params);

        $response->assertStatus(422)
                ->assertJson([
                    'message' => 'Este feed já está cadastrado'
                ]);
    }
}
