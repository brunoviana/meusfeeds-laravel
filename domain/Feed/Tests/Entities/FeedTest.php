<?php

namespace Domain\Feed\Tests\Entities;

use Domain\Feed\Entities\Feed;
use Domain\Feed\ValueObjects\ArtigoList;
use Domain\Feed\ValueObjects\Data;

trait FeedTest
{
    public function test_Novo_Feed_Deve_Comecar_Com_Zero_Artigos()
    {
        $feed = Feed::novo(
            'Blog do Bruno',
            'https://brunoviana.dev'
        );
        
        $this->assertCount(0, $feed->artigos());
        $this->assertInstanceOf(ArtigoList::class, $feed->artigos());
    }

    public function test_Novo_Feed_Deve_Ter_Data_Vazia_Se_Nao_Especificado()
    {
        $feed = Feed::novo(
            'Blog do Bruno',
            'https://brunoviana.dev'
        );
        
        $this->assertInstanceOf(Data::class, $feed->ultimaAtualizacao());
        $this->assertTrue($feed->ultimaAtualizacao()->vazio());
    }

    public function test_Deve_Disparar_Erro_Se_Data_Atualizacao_E_Invalida()
    {
        $this->expectException(\RuntimeException::class);

        $feed = Feed::novo(
            'Blog do Bruno',
            'https://brunoviana.dev'
        );
        
        $feed->ultimaAtualizacao('2020-01-01');
    }
}
