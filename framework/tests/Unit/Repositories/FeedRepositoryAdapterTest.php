<?php

namespace Tests\Framework\Unit\Repositories;

use Domain\Feed\Entities\Feed;
use Domain\Feed\ValueObjects\Autor;
use Domain\Feed\ValueObjects\Data;

use App\Feed\Exceptions\FeedNaoEncontradoException;

use Framework\Models\Feed as FeedModel;
use Framework\Models\Feed\Artigo as ArtigoModel;
use Framework\Repositories\Feed\FeedRepositoryAdapter;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeedRepositoryAdapterTest extends TestCase
{
    use RefreshDatabase;

    public function test_FeedRepository_Deve_Feed_Buscar_Pelo_Id()
    {
        factory(FeedModel::class, 1)->create([
            'titulo' => 'Blog do Bruno',
            'link_rss' => 'https://brunoviana.dev/rss.xml'
        ]);

        $repository = new FeedRepositoryAdapter();
        $feed = $repository->buscar(1);

        $this->assertInstanceOf(Feed::class, $feed);
        $this->assertEquals('Blog do Bruno', $feed->titulo());
    }

    public function test_FeedRepository_Deve_Falhar_Se_Nao_Achar_Feed_Pelo_Id()
    {
        $this->expectException(FeedNaoEncontradoException::class);

        $repository = new FeedRepositoryAdapter();
        $feed = $repository->buscar(1);

        $this->assertInstanceOf(Feed::class, $feed);
        $this->assertEquals('Blog do Bruno', $feed->titulo());
    }

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

    public function test_FeedRepository_Deve_Falhar_Se_Nao_Achar_Feed_Pelo_Link()
    {
        $this->expectException(FeedNaoEncontradoException::class);

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

    public function test_FeedRepository_Deve_Salvar_Artigos_Tambem()
    {
        $feed = Feed::novo(
            'Blog do Bruno',
            'https://brunoviana.dev/rss.xml'
        );

        $feed->artigos()->adicionar(
            'Titulo do Artigo',
            'Descrição do Artigo',
            'http://link.co.br',
            new Autor('Autor do Artigo'),
            new Data(2020, 10, 10)
        );

        $repository = new FeedRepositoryAdapter();
        $id = $repository->save($feed);

        $this->assertEquals(1, $id);
        $this->assertCount(1, FeedModel::all());
        $this->assertCount(1, ArtigoModel::all());
    }

    public function test_FeedRepository_Deve_Sempre_Recriar_Artigos_Ao_Salvar()
    {
        $feed = Feed::novo(
            'Blog do Bruno',
            'https://brunoviana.dev/rss.xml'
        );

        $feed->artigos()->adicionar(
            'Titulo do Artigo',
            'Descrição do Artigo',
            'http://link.co.br',
            new Autor('Autor do Artigo'),
            new Data(2020, 10, 10)
        );

        $repository = new FeedRepositoryAdapter();

        $repository->save($feed);

        $this->assertCount(1, ArtigoModel::all());
        $this->assertEquals(1, ArtigoModel::all()->first()->id);

        $repository->save($feed);

        $this->assertCount(1, ArtigoModel::all());
        $this->assertEquals(2, ArtigoModel::all()->first()->id);
    }

    public function test_FeedRepository_Deve_Trazer_Artigos_Ao_Buscar_Feed()
    {
        $feedModel = factory(FeedModel::class, 1)->create([
            'titulo' => 'Blog do Bruno',
            'link_rss' => 'https://brunoviana.dev/rss.xml'
        ])->first();

        $artigoModel = factory(ArtigoModel::class, 1)->create([
            'titulo' => 'Titulo do Artigo',
            'descricao' => 'Descrição do Artigo',
            'link' => 'http://link.co.br',
            'autor' => 'Autor',
            'data_publicacao' => '2020-10-10',
            'lido' => 0,
            'feed_id' => $feedModel->id
        ])->first();

        $repository = new FeedRepositoryAdapter();

        $feed = $repository->buscar($feedModel->id);

        $this->assertCount(1, $feed->artigos());
    }

    public function test_FeedRepository_Deve_Retornar_Data_Da_Ultima_Atualizacao()
    {
        $feedModel = factory(FeedModel::class, 1)->create([
            'titulo' => 'Blog do Bruno',
            'link_rss' => 'https://brunoviana.dev/rss.xml'
        ])->first();

        $artigoModel = factory(ArtigoModel::class, 1)->create([
            'titulo' => 'Titulo do Artigo',
            'descricao' => 'Descrição do Artigo',
            'link' => 'http://link.co.br',
            'autor' => 'Autor',
            'data_publicacao' => '2020-10-10',
            'lido' => 0,
            'feed_id' => $feedModel->id
        ])->first();

        $repository = new FeedRepositoryAdapter();
        $feed = $repository->buscarPeloLink('https://brunoviana.dev/rss.xml');

        $this->assertEquals(
            $artigoModel->created_at->format('Y-m-d'),
            $repository->dataDaUltimaAtualizacao($feed)->formatoPadrao()
        );
    }

    public function test_FeedRepository_Deve_Retornar_Data_Vazia()
    {
        $feedModel = factory(FeedModel::class, 1)->create([
            'titulo' => 'Blog do Bruno',
            'link_rss' => 'https://brunoviana.dev/rss.xml'
        ])->first();

        $repository = new FeedRepositoryAdapter();
        $feed = $repository->buscarPeloLink('https://brunoviana.dev/rss.xml');

        $this->assertInstanceOf(Feed::class, $feed);
        $this->assertTrue(
            $repository->dataDaUltimaAtualizacao($feed)->vazio()
        );
    }
}
