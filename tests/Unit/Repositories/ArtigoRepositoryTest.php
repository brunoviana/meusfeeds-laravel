<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;

use MeusFeeds\Feeds\Domain\Entities\Artigo;
use MeusFeeds\Feeds\Domain\ValueObjects\Data;
use MeusFeeds\Feeds\Domain\ValueObjects\Autor;
use App\Models\Feed as FeedModel;
use App\Models\Artigo as ArtigoModel;

use App\Repositories\ArtigoRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArtigoRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_Deve_Buscar_Todos_Os_Artigos()
    {
        $this->criaArtigo();

        $artigoRepository = new ArtigoRepository();
        $artigos = $artigoRepository->todos();

        $this->assertIsArray($artigos);
        $this->assertCount(1, $artigos);
    }

    public function test_Deve_Salvar_Um_Artigo_Com_Sucesso()
    {
        $feedModel = factory(FeedModel::class, 1)->create([
            'titulo' => 'Blog do Bruno',
            'link_rss' => 'https://brunoviana.dev/rss.xml',
        ])->first();

        $this->assertCount(0, ArtigoModel::all());

        $artigo = Artigo::novo(
            'Hello World',
            'Meu primeiro artigo',
            'https://brunoviana.net/hello-world',
            new Autor('Bruno Viana'),
            new Data(2020, 01, 01),
            $feedModel->id,
            Artigo::NAO_LIDO
        );

        $artigoRepository = new ArtigoRepository();
        $artigoRepository->salvar($artigo);

        $this->assertCount(1, ArtigoModel::all());
        $this->assertEquals(1, $artigo->id());
    }

    public function test_Deve_Salvar_Varios_Artigos_Com_Sucesso()
    {
        $feedModel = factory(FeedModel::class, 1)->create([
            'titulo' => 'Blog do Bruno',
            'link_rss' => 'https://brunoviana.dev/rss.xml',
        ])->first();

        $this->assertCount(0, ArtigoModel::all());

        $artigo1 = Artigo::novo(
            'Hello World',
            'Meu primeiro artigo',
            'https://brunoviana.net/hello-world',
            new Autor('Bruno Viana'),
            new Data(2020, 01, 01),
            $feedModel->id,
            Artigo::NAO_LIDO
        );

        $artigo2 = Artigo::novo(
            'Hello Brasil',
            'Meu segundo artigo',
            'https://brunoviana.net/hello-brasil',
            new Autor('Bruno Viana'),
            new Data(2020, 02, 01),
            $feedModel->id,
            Artigo::NAO_LIDO
        );

        $artigoRepository = new ArtigoRepository();
        $artigoRepository->salvarVarios([
            $artigo1, $artigo2
        ]);

        $this->assertCount(2, ArtigoModel::all());
        $this->assertEquals(1, $artigo1->id());
        $this->assertEquals(2, $artigo2->id());
    }

    public function criaArtigo()
    {
        $feedModel = factory(FeedModel::class, 1)->create([
            'titulo' => 'Blog do Bruno',
            'link_rss' => 'https://brunoviana.dev/rss.xml',
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
    }
}
