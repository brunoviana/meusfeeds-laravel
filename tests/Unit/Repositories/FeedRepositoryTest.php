<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;

use MeusFeeds\Feeds\Domain\Entities\Feed;
use App\Models\Feed as FeedModel;

use App\Repositories\FeedRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeedRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_Deve_Buscar_Feed_Pelo_Id()
    {
        factory(FeedModel::class, 1)->create([
            'titulo' => 'Blog do Bruno',
            'link_rss' => 'https://brunoviana.dev/rss.xml'
        ]);

        $feedRepository = new FeedRepository();
        $feed = $feedRepository->buscar(1);

        $this->assertInstanceOf(Feed::class, $feed);
        $this->assertEquals('Blog do Bruno', $feed->titulo());
    }

    public function test_Deve_Retornar_Nulo_Se_Nao_Achar_Feed_Pelo_Id()
    {
        $repository = new FeedRepository();
        $feed = $repository->buscar(1);

        $this->assertNull($feed);
    }

    public function test_Deve_Buscar_Feed_Pelo_Link()
    {
        factory(FeedModel::class, 1)->create([
            'titulo' => 'Blog do Bruno',
            'link_rss' => 'https://brunoviana.dev/rss.xml'
        ]);

        $repository = new FeedRepository();
        $feed = $repository->buscarPeloLink('https://brunoviana.dev/rss.xml');

        $this->assertInstanceOf(Feed::class, $feed);
        $this->assertEquals('Blog do Bruno', $feed->titulo());
    }

    public function test_Deve_Retornar_Nulo_Se_Nao_Achar_Feed_Pelo_Link()
    {
        $repository = new FeedRepository();
        $feed = $repository->buscarPeloLink('https://brunoviana.dev/rss.xml');

        $this->assertNull($feed);
    }

    public function test_Deve_Salvar_Feed_Com_Sucesso()
    {
        $feed = new Feed(
            'Blog do Bruno',
            'https://brunoviana.dev/rss.xml'
        );

        $repository = new FeedRepository();
        $repository->salvar($feed);

        $this->assertCount(1, FeedModel::all());
    }

    public function test_Deve_Setar_Id_Do_Feed_Ao_Salvar()
    {
        $feed = new Feed(
            'Blog do Bruno',
            'https://brunoviana.dev/rss.xml'
        );

        $repository = new FeedRepository();
        $repository->salvar($feed);

        $this->assertEquals(1, $feed->id());
    }
}
