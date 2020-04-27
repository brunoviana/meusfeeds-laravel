<?php

namespace Domain\Feed\Tests\Entities;

use Domain\Feed\Entities\Feed;
use Domain\Feed\ValueObjects\ArtigoList;
use Domain\Feed\ValueObjects\Artigo;
use Domain\Feed\ValueObjects\Data;
use Domain\Feed\ValueObjects\Autor;
use Domain\Feed\Interfaces\Services\BuscadorDeArtigosServiceInterface;

trait FeedTest
{
    abstract protected function makeMock($class, $assertions=null);

    abstract protected function makePartialMock($class, $assertions=null);

    abstract protected function getInstance($class);

    public function test_Novo_Feed_Deve_Comecar_Com_Zero_Artigos()
    {
        $buscadorDeArtigoService = $this->criaMockDoBuscadorDeArtigo();

        $feed = new Feed(
            'Blog do Bruno',
            'https://brunoviana.dev',
            $buscadorDeArtigoService
        );
        
        $this->assertCount(0, $feed->artigos());
        $this->assertInstanceOf(ArtigoList::class, $feed->artigos());
    }

    public function test_Deve_Atualizar_Artigos_Do_Feed_Com_Sucesso()
    {
        $buscadorDeArtigoService = $this->criaMockDoBuscadorDeArtigo();

        $feed = new Feed(
            'Blog do Bruno',
            'https://brunoviana.dev',
            $buscadorDeArtigoService
        );

        $feed->atualizar();

        $artigos = $feed->artigos();

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

    public function test_Deve_Mudar_Data_De_Ultima_Atualizacao_Quando_Atualizar()
    {
        $buscadorDeArtigoService = $this->criaMockDoBuscadorDeArtigo();
        
        $feed = new Feed(
            'Blog do Bruno',
            'https://brunoviana.dev',
            $buscadorDeArtigoService
        );
        
        $this->assertEquals('0000-00-00', $feed->ultimaAtualizacao()->formatoPadrao());

        $feed->atualizar();

        $artigos = $feed->artigos();

        $this->assertEquals(date('Y-m-d'), $feed->ultimaAtualizacao()->formatoPadrao());
    }

    public function criaMockDoBuscadorDeArtigo()
    {
        return $this->makeMock(
            BuscadorDeArtigosServiceInterface::class,
            function ($mock) {
                $artigoList = new ArtigoList();

                $artigoList->adicionar(
                    'Meu primeiro artigo',
                    'Neste artigo você verá como fiz meu primeiro artigo',
                    'https://brunoviana.dev/primeiro-artigo',
                    new Autor('Bruno Viana'),
                    new Data(2020, 1, 1)
                );

                $mock->shouldReceive('buscar')->andReturn($artigoList);
            }
        );
    }
}
