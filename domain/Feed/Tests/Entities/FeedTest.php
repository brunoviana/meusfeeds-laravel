<?php

namespace Domain\Feed\Tests\Entities;

use Domain\Feed\Entities\Feed;
use Domain\Feed\ValueObjects\ArtigoList;
use Domain\Feed\ValueObjects\Data;
use Domain\Feed\ValueObjects\Autor;
use Domain\Feed\Interfaces\Services\BuscadorDeArtigosServiceInterface;

trait FeedTest
{
    public function test_Novo_Feed_Deve_Comecar_Com_Zero_Artigos()
    {
        $feed = new Feed(
            'Blog do Bruno',
            'https://brunoviana.dev'
        );
        
        $this->assertCount(0, $feed->artigos());
        $this->assertInstanceOf(ArtigoList::class, $feed->artigos());
    }

    public function test_Novo_Feed_Deve_Ter_Data_Vazia_Se_Nao_Especificado()
    {
        $feed = new Feed(
            'Blog do Bruno',
            'https://brunoviana.dev'
        );
        
        $this->assertInstanceOf(Data::class, $feed->ultimaAtualizacao());
        $this->assertTrue($feed->ultimaAtualizacao()->vazio());
    }

    public function test_Deve_Mudar_Data_De_Ultima_Atualizacao_Quando_Adicionar_Artigo()
    {
        $feed = new Feed(
            'Blog do Bruno',
            'https://brunoviana.dev'
        );
        
        $this->assertEquals('0000-00-00', $feed->ultimaAtualizacao()->formatoPadrao());

        $feed->adicionarArtigo(
            'Titulo do Artigo',
            'Descricap do Artigo',
            'http://link-do-artigo',
            new Autor('Autor do Artigo'),
            new Data(2020, 01, 01)
        );

        $this->assertEquals(date('Y-m-d'), $feed->ultimaAtualizacao()->formatoPadrao());
    }
}
