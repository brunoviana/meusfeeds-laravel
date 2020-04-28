<?php

namespace App\Feed\Tests\Services;

use Domain\Feed\ValueObjects\ArtigoList;
use Domain\Feed\ValueObjects\Artigo;
use Domain\Feed\ValueObjects\Data;
use Domain\Feed\ValueObjects\Autor;
use Domain\Feed\Entities\Feed;

use App\Feed\Services\BuscadorDeArtigosService;
use App\Feed\Exceptions\ResponseInvalidoException;
use App\Feed\Interfaces\Adapters\BuscadorDeArtigosAdapterInterface;

trait BuscadorDeArtigosServiceTest
{
    public function test_Deve_Encontrar_Todos_Artigos_Com_Sucesso()
    {
        $dadosDoArtigo = $this->dadosDoArtigo();

        $this->makeMock(
            BuscadorDeArtigosAdapterInterface::class,
            function ($mock) use ($dadosDoArtigo) {
                $mock->shouldReceive('buscar')
                    ->with('https://brunoviana.dev/rss.xml', '')
                    ->andReturn([ $dadosDoArtigo ]);
            }
        );

        $buscadorDeArtigos = $this->getInstance(BuscadorDeArtigosService::class);

        $artigos = $buscadorDeArtigos->buscarAPartirDe('https://brunoviana.dev/rss.xml', new Data());

        $this->assertListaDeArtigos($artigos);
    }

    public function test_Deve_Buscar_Artigos_A_Partir_De_Uma_Data()
    {
        $dadosDoArtigo = $this->dadosDoArtigo();

        $this->makeMock(
            BuscadorDeArtigosAdapterInterface::class,
            function ($mock) use ($dadosDoArtigo) {
                $mock->shouldReceive('buscar')
                    ->with('https://brunoviana.dev/rss.xml', '2020-01-01')
                    ->andReturn([ $dadosDoArtigo ]);
            }
        );

        $buscadorDeArtigos = $this->getInstance(BuscadorDeArtigosService::class);

        $artigos = $buscadorDeArtigos->buscarAPartirDe(
            'https://brunoviana.dev/rss.xml',
            new Data(2020, 01, 01)
        );

        $this->assertListaDeArtigos($artigos);
    }

    public function test_Deve_Buscar_E_Atualizar_Um_Feed()
    {
        $dadosDoArtigo = $this->dadosDoArtigo();

        $this->makeMock(
            BuscadorDeArtigosAdapterInterface::class,
            function ($mock) use ($dadosDoArtigo) {
                $mock->shouldReceive('buscar')
                    ->with('https://brunoviana.dev/rss.xml', '')
                    ->andReturn([ $dadosDoArtigo ]);
            }
        );

        $feed = Feed::novo('Meu blog', 'https://brunoviana.dev/rss.xml');
        $buscadorDeArtigos = $this->getInstance(BuscadorDeArtigosService::class);

        $buscadorDeArtigos->buscarEAtualizar($feed, new Data());

        $this->assertListaDeArtigos($feed->artigos());
    }

    public function test_Deve_Buscar_E_Atualizar_Um_Feed_A_Partir_Da_Ultima_Atualizacao()
    {
        $dadosDoArtigo = $this->dadosDoArtigo();

        $this->makeMock(
            BuscadorDeArtigosAdapterInterface::class,
            function ($mock) use ($dadosDoArtigo) {
                $mock->shouldReceive('buscar')
                    ->with('https://brunoviana.dev/rss.xml', '2020-01-01')
                    ->andReturn([ $dadosDoArtigo ]);
            }
        );

        $feed = Feed::novo('Meu blog', 'https://brunoviana.dev/rss.xml');
        $buscadorDeArtigos = $this->getInstance(BuscadorDeArtigosService::class);

        $buscadorDeArtigos->buscarEAtualizar($feed, new Data(2020, 01, 01));

        $this->assertListaDeArtigos($feed->artigos());
    }

    public function test_Deve_Falhar_Se_Resposta_Do_Adapter_E_Invalida()
    {
        $this->expectException(ResponseInvalidoException::class);

        $dadosDoArtigoErrado = $this->dadosDoArtigoErrado();

        $this->makeMock(
            BuscadorDeArtigosAdapterInterface::class,
            function ($mock) use ($dadosDoArtigoErrado) {
                $mock->shouldReceive('buscar')
                    ->with('https://brunoviana.dev/rss.xml', '')
                    ->andReturn([ $dadosDoArtigoErrado ]);
            }
        );

        $feed = Feed::novo('Meu blog', 'https://brunoviana.dev/rss.xml');
        
        $buscadorDeArtigos = $this->getInstance(BuscadorDeArtigosService::class);

        $buscadorDeArtigos->buscarEAtualizar($feed, new Data());
    }

    public function assertListaDeArtigos($artigos)
    {
        $this->assertInstanceOf(ArtigoList::class, $artigos);
        $this->assertCount(1, $artigos);

        $this->assertInstanceOf(Artigo::class, $artigos->primeiro());
        $this->assertInstanceOf(Autor::class, $artigos->primeiro()->autor());
        $this->assertInstanceOf(Data::class, $artigos->primeiro()->dataPublicacao());

        $this->assertEquals('Meu primeiro artigo', $artigos->primeiro()->titulo());
        $this->assertEquals('Neste artigo você verá como fiz meu primeiro artigo', $artigos->primeiro()->descricao());
        $this->assertEquals('https://brunoviana.dev/primeiro-artigo', $artigos->primeiro()->link());
        $this->assertEquals('Bruno Viana', $artigos->primeiro()->autor()->nome());
        $this->assertEquals('2020-01-01', $artigos->primeiro()->dataPublicacao()->formatoPadrao());
    }

    public function dadosDoArtigo()
    {
        return [
            'titulo' => 'Meu primeiro artigo',
            'descricao' => 'Neste artigo você verá como fiz meu primeiro artigo',
            'link' => 'https://brunoviana.dev/primeiro-artigo',
            'autor' => 'Bruno Viana',
            'data_publicacao' => '2020-01-01'
        ];
    }

    public function dadosDoArtigoErrado()
    {
        return [
            'Titulo' => 'Meu primeiro artigo',
            'Descricao' => 'Neste artigo você verá como fiz meu primeiro artigo',
            'Link' => 'https://brunoviana.dev/primeiro-artigo',
            'Autor' => 'Bruno Viana',
            'Data_publicacao' => '2020-01-01'
        ];
    }
}
