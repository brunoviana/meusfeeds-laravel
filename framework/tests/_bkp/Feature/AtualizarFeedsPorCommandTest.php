<?php

namespace Tests\Framework\Feature;

use Domain\Feed\Entities\Feed;

use Framework\Models\Feed as FeedModel;
use Framework\Models\Feed\Artigo;
use Framework\Adapters\Feed\BuscadorDeArtigosAdapter;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AtualizarFeedsPorCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_Command_Deve_Atualizar_Todos_Os_Feeds_Com_Sucesso()
    {
        factory(FeedModel::class, 1)->create([
            'titulo' => 'Blog do Bruno',
            'link_rss' => 'https://brunoviana.dev/rss.xml'
        ]);

        $this->makeMock(BuscadorDeArtigosAdapter::class, function ($mock) {
            $mock->shouldReceive('buscar')
                    ->andReturn([
                        [
                            'titulo' => 'Meu primeiro artigo',
                            'descricao' => 'Neste artigo você verá como fiz meu primeiro artigo',
                            'link' => 'https://brunoviana.dev/primeiro-artigo',
                            'autor' => 'Bruno Viana',
                            'data_publicacao' => '2020-01-01'
                        ],
                        [
                            'titulo' => 'Meu segundo artigo',
                            'descricao' => 'Neste artigo você verá como fiz meu segundo artigo',
                            'link' => 'https://brunoviana.dev/segundo-artigo',
                            'autor' => 'Bruno Viana',
                            'data_publicacao' => '2020-01-02'
                        ],
                        [
                            'titulo' => 'Meu terceiro artigo',
                            'descricao' => 'Neste artigo você verá como fiz meu priterceiromeiro artigo',
                            'link' => 'https://brunoviana.dev/terceiro-artigo',
                            'autor' => 'Bruno Viana',
                            'data_publicacao' => '2020-01-03'
                        ],
                    ]);
        });

        $this->artisan('feed:atualizar');

        $this->assertCount(3, Artigo::all());
    }
}
