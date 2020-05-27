<?php

namespace Tests\Feature\Console;

use Tests\TestCase;
use MeusFeeds\Feeds\Domain\Entities\Artigo;
use MeusFeeds\Feeds\Domain\ValueObjects\Data;

use MeusFeeds\Feeds\Domain\ValueObjects\Autor;
use App\Models\Feed as FeedModel;
use App\Services\BuscadorDeArtigos;

use App\Models\Artigo as ArtigoModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AtualizarFeedsTest extends TestCase
{
    use RefreshDatabase;

    public function test_Command_Deve_Atualizar_Todos_Os_Feeds_Com_Sucesso()
    {
        factory(FeedModel::class, 1)->create([
            'titulo' => 'Blog do Bruno',
            'link_rss' => 'https://brunoviana.dev/rss.xml'
        ]);

        $this->makeMock(BuscadorDeArtigos::class, function ($mock) {
            $mock->shouldReceive('buscarNovos')
                    ->andReturn([
                        Artigo::novo(
                            'Meu primeiro artigo',
                            'Neste artigo você verá como fiz meu primeiro artigo',
                            'https://brunoviana.dev/primeiro-artigo',
                            new Autor('Bruno Viana'),
                            new Data(2020, 02, 01),
                            1,
                            Artigo::NAO_LIDO
                        ),
                        Artigo::novo(
                            'Meu segundo artigo',
                            'Neste artigo você verá como fiz meu segundo artigo',
                            'https://brunoviana.dev/segundo-artigo',
                            new Autor('Bruno Viana'),
                            new Data(2020, 02, 01),
                            1,
                            Artigo::NAO_LIDO
                        ),
                        Artigo::novo(
                            'Meu terceiro artigo',
                            'Neste artigo você verá como fiz meu priterceiromeiro artigo',
                            'https://brunoviana.dev/terceiro-artigo',
                            new Autor('Bruno Viana'),
                            new Data(2020, 02, 01),
                            1,
                            Artigo::NAO_LIDO
                        ),
                    ]);
        });

        $this->artisan('feed:atualizar');

        $this->assertCount(3, ArtigoModel::all());
    }
}
