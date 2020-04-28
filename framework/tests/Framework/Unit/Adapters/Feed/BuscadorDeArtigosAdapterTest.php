<?php

namespace Tests\Framework\Unit\Framework\Adapters\Feed;

use Framework\Models\Feed as FeedModel;
use Framework\Adapters\Feed\BuscadorDeArtigosAdapter;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BuscadorDeArtigosAdapterTest extends TestCase
{
    use RefreshDatabase;

    public function test_Deve_Buscar_Todos_Os_Artigos_Com_Sucesso()
    {
        $feedModel = $this->criaFeedNoBancoDeDados();

        $this->criaFeedIoMocks();

        $adapter = app(BuscadorDeArtigosAdapter::class);

        $result = $adapter->buscar(
            $feedModel->entity()
        );

        $this->assertCount(1, $result);
        $this->assertArraySubset($this->dadosArtigo(), $result[0]);
    }

    public function test_Deve_Buscar_Artigos_A_Partir_Da_Data_Com_Sucesso()
    {
        $feedModel = $this->criaFeedNoBancoDeDados();

        $this->criaFeedIoMocks(true);

        $adapter = app(BuscadorDeArtigosAdapter::class);

        $result = $adapter->buscar($feedModel->entity(), '2020-01-01');

        $this->assertCount(1, $result);
        $this->assertArraySubset($this->dadosArtigo(), $result[0]);
    }

    public function criaFeedNoBancoDeDados()
    {
        return factory(FeedModel::class, 1)->create([
            'titulo' => 'Blog do Bruno',
            'link_rss' => 'https://brunoviana.dev/rss.xml'
        ])->first();
    }

    public function dadosArtigo()
    {
        return [
            'titulo' => 'Blog do Bruno',
            'descricao' => 'Este é o meu blog',
            'link' => 'https://brunoviana.dev',
            'autor' => 'Bruno Viana',
            'data_publicacao' => date('Y-m-d'),
        ];
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
