<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Feed\Domain\Entities\Feed;

use Feed\Domain\Entities\Artigo;
use Framework\Models\Feed as FeedModel;
use Framework\Services\BuscadorDeArtigos;
use Framework\Repositories\FeedRepository;

use Framework\Models\Artigo as ArtigoModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BuscadorDeArtigosTest extends TestCase
{
    use RefreshDatabase;

    public function test_Deve_Buscar_Todos_Os_Artigos_Com_Sucesso()
    {
        $feed = Feed::novo(
            'Blog do Bruno',
            'https://brunoviana.dev/rss.xml'
        );

        $this->criaFeedIoMocks();

        $adapter = app(BuscadorDeArtigos::class);

        $result = $adapter->buscarTodos($feed);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(Artigo::class, $result[0]);
    }

    public function test_Deve_Buscar_Artigos_Novos_Com_Sucesso()
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
            'created_at' => '2020-01-01 14:41:19',
            'updated_at' => '2020-01-01 14:41:19',
        ]);

        factory(ArtigoModel::class, 1)->create([
            'titulo' => 'Segundo Artigo',
            'descricao' => 'Este é o segundo artigo',
            'link' => 'https://brunoviana.dev/segundo-artigo',
            'autor' => 'Bruno Viana',
            'data_publicacao' => '2020-01-02',
            'lido' => 0,
            'feed_id' => $feedModel->id,
            'created_at' => '2020-01-02 14:41:19',
            'updated_at' => '2020-01-02 14:41:19',
        ]);

        $feedRepository = new FeedRepository();
        $feed = $feedRepository->buscar($feedModel->id);

        $this->criaFeedIoMocks(true);

        $adapter = app(BuscadorDeArtigos::class);

        $result = $adapter->buscarNovos($feed);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(Artigo::class, $result[0]);
    }

    public function test_Deve_Buscar_Todos_Se_Ainda_Nao_Tiver_Artigo_Ao_Buscar_Novos()
    {
        $feed = Feed::novo(
            'Blog do Bruno',
            'https://brunoviana.dev/rss.xml'
        );

        $this->criaFeedIoMocks();

        $adapter = app(BuscadorDeArtigos::class);

        $result = $adapter->buscarNovos($feed);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(Artigo::class, $result[0]);
    }

    public function criaFeedIoMocks($aPartirDe=false)
    {
        $artigoFeedMock = app(\FeedIo\Feed::class);

        $artigoMock = $this->mock(\FeedIo\Feed\Item::class, function ($mock) {
            $autor = new \FeedIo\Feed\Item\Author();
            $autor->setName('Bruno Viana');

            $mock->shouldReceive('getTitle')->andReturn('Blog do Bruno');
            $mock->shouldReceive('getDescription')->andReturn('Este é o meu blog');
            $mock->shouldReceive('getLink')->andReturn('https://brunoviana.dev');
            $mock->shouldReceive('getAuthor')->andReturn($autor);
            $mock->shouldReceive('getLastModified')->andReturn(new \DateTime());
        });

        $artigoFeedMock->add($artigoMock);

        $readResult = $this->mock(\FeedIo\Reader\Result::class, function ($mock) use ($artigoFeedMock) {
            $mock->shouldReceive('getFeed')->andReturn(
                $artigoFeedMock
            );
        });

        $this->mock(\FeedIo\FeedIo::class, function ($mock) use ($readResult, $aPartirDe) {
            if ($aPartirDe) {
                $mock->shouldReceive('readSince')
                    ->withArgs(function ($link, $data) { // Fiz assim por que o Mockery não trata bem objetos no with()
                        if ($link !== 'https://brunoviana.dev/rss.xml') {
                            return false;
                        }

                        if ($data->format('Y-m-d') !== '2020-01-01') {
                            return false;
                        }

                        return true;
                    })
                    ->andReturn($readResult);
            } else {
                $mock->shouldReceive('read')
                    ->with('https://brunoviana.dev/rss.xml')
                    ->andReturn($readResult);
            }
        });
    }
}
