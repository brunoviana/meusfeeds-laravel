<?php

namespace Domain\Feed\Tests\ValueObjects;

use Domain\Feed\ValueObjects\Artigo;
use Domain\Feed\ValueObjects\Data;
use Domain\Feed\ValueObjects\Autor;

trait ArtigoTest
{
    public function test_Deve_Marcar_Artigo_Como_Lido()
    {
        $artigo = new Artigo(
            'Titulo do Artigo',
            'Descrição do Artigo',
            'http://link-do-artigo',
            new Autor('Autor do Artigo'),
            Data::agora(),
            0
        );

        $this->assertFalse($artigo->lido());

        $artigo->marcarComoLido();

        $this->assertTrue($artigo->lido());
    }

    public function test_Deve_Marcar_Artigo_Como_Nao_Lido()
    {
        $artigo = new Artigo(
            'Titulo do Artigo',
            'Descrição do Artigo',
            'http://link-do-artigo',
            new Autor('Autor do Artigo'),
            Data::agora(),
            1
        );

        $this->assertTrue($artigo->lido());
        
        $artigo->marcarComoNaoLido();
        
        $this->assertFalse($artigo->lido());
    }
}
