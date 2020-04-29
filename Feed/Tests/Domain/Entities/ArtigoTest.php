<?php

namespace Feed\Tests\Domain\Entities;

use Feed\Domain\Entities\Artigo;

use Tests\TestCase;

class ArtigoTest extends TestCase
{
    public function test_Novo_Artigo_Deve_Comecar_Com_Id_Zero()
    {
        $artigo = Artigo::novo();
        
        $this->assertEquals(0, $artigo->id());
    }

    public function test_Novo_Artigo_Deve_Inserir_Id_Com_Sucesso()
    {
        $artigo = Artigo::novo();
        $artigo->id(1);
        
        $this->assertEquals(1, $artigo->id());
    }

    public function test_Deve_Falhar_Setar_Id_Do_Artigo_Se_Ja_Tiver_Id()
    {
        $this->expectException(\RuntimeException::class);

        $artigo = Artigo::novo();

        $artigo->id(1);
        $artigo->id(2);
    }
}
