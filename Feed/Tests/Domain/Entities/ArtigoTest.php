<?php

namespace Feed\Tests\Domain\Entities;

use Tests\TestCase;
use Feed\Domain\Entities\Artigo;
use Feed\Domain\ValueObjects\Data;

use Feed\Domain\ValueObjects\Autor;

class ArtigoTest extends TestCase
{
    public function test_Novo_Artigo_Deve_Comecar_Com_Id_Zero()
    {
        $artigo = Artigo::novo(
            'Hello World',
            'Meu primeiro artigo',
            'https://brunoviana.net/hello-world',
            new Autor('Bruno Viana'),
            new Data(2020, 01, 01),
            0,
            Artigo::NAO_LIDO
        );

        $this->assertEquals(0, $artigo->id());
    }

    public function test_Novo_Artigo_Deve_Inserir_Id_Com_Sucesso()
    {
        $artigo = Artigo::novo(
            'Hello World',
            'Meu primeiro artigo',
            'https://brunoviana.net/hello-world',
            new Autor('Bruno Viana'),
            new Data(2020, 01, 01),
            0,
            Artigo::NAO_LIDO
        );
        $artigo->id(1);

        $this->assertEquals(1, $artigo->id());
    }

    public function test_Deve_Falhar_Setar_Id_Do_Artigo_Se_Ja_Tiver_Id()
    {
        $this->expectException(\RuntimeException::class);

        $artigo = Artigo::novo(
            'Hello World',
            'Meu primeiro artigo',
            'https://brunoviana.net/hello-world',
            new Autor('Bruno Viana'),
            new Data(2020, 01, 01),
            0,
            Artigo::NAO_LIDO
        );

        $artigo->id(1);
        $artigo->id(2);
    }

    public function test_Deve_Retornar_Titulo_Corretamente()
    {
        $artigo = Artigo::novo(
            'Hello World',
            'Meu primeiro artigo',
            'https://brunoviana.net/hello-world',
            new Autor('Bruno Viana'),
            new Data(2020, 01, 01),
            0,
            Artigo::NAO_LIDO
        );

        $this->assertEquals('Hello World', $artigo->titulo());
    }

    public function test_Deve_Retornar_Descricao_Corretamente()
    {
        $artigo = Artigo::novo(
            'Hello World',
            'Meu primeiro artigo',
            'https://brunoviana.net/hello-world',
            new Autor('Bruno Viana'),
            new Data(2020, 01, 01),
            0,
            Artigo::NAO_LIDO
        );

        $this->assertEquals('Meu primeiro artigo', $artigo->descricao());
    }

    public function test_Deve_Retornar_Link_Corretamente()
    {
        $artigo = Artigo::novo(
            'Hello World',
            'Meu primeiro artigo',
            'https://brunoviana.net/hello-world',
            new Autor('Bruno Viana'),
            new Data(2020, 01, 01),
            0,
            Artigo::NAO_LIDO
        );

        $this->assertEquals('https://brunoviana.net/hello-world', $artigo->link());
    }

    public function test_Deve_Retornar_Autor_Corretamente()
    {
        $artigo = Artigo::novo(
            'Hello World',
            'Meu primeiro artigo',
            'https://brunoviana.net/hello-world',
            new Autor('Bruno Viana'),
            new Data(2020, 01, 01),
            0,
            Artigo::NAO_LIDO
        );

        $this->assertInstanceOf(Autor::class, $artigo->autor());
        $this->assertEquals('Bruno Viana', $artigo->autor()->nome());
    }

    public function test_Deve_Retornar_Data_Da_Publicacao_Corretamente()
    {
        $artigo = Artigo::novo(
            'Hello World',
            'Meu primeiro artigo',
            'https://brunoviana.net/hello-world',
            new Autor('Bruno Viana'),
            new Data(2020, 01, 01),
            0,
            Artigo::NAO_LIDO
        );

        $this->assertInstanceOf(Data::class, $artigo->dataPublicacao());
        $this->assertEquals('2020-01-01', $artigo->dataPublicacao()->formatoPadrao());
    }

    public function test_Deve_Retornar_Se_Artigo_Foi_Lido_Corretamente()
    {
        $artigo = Artigo::novo(
            'Hello World',
            'Meu primeiro artigo',
            'https://brunoviana.net/hello-world',
            new Autor('Bruno Viana'),
            new Data(2020, 01, 01),
            0,
            Artigo::NAO_LIDO
        );

        $this->assertFalse($artigo->lido());
    }

    public function test_Deve_Marcar_Artigo_Como_Lido_Corretamente()
    {
        $artigo = Artigo::novo(
            'Hello World',
            'Meu primeiro artigo',
            'https://brunoviana.net/hello-world',
            new Autor('Bruno Viana'),
            new Data(2020, 01, 01),
            0,
            Artigo::NAO_LIDO
        );

        $artigo->lido(Artigo::LIDO);

        $this->assertTrue($artigo->lido());
    }

    public function test_Deve_Marcar_Artigo_Como_Nao_Lido_Corretamente()
    {
        $artigo = Artigo::novo(
            'Hello World',
            'Meu primeiro artigo',
            'https://brunoviana.net/hello-world',
            new Autor('Bruno Viana'),
            new Data(2020, 01, 01),
            0,
            Artigo::LIDO
        );

        $artigo->lido(Artigo::NAO_LIDO);

        $this->assertFalse($artigo->lido());
    }

    public function test_Deve_Retornar_Id_Do_Feed_Corretamente()
    {
        $artigo = Artigo::novo(
            'Hello World',
            'Meu primeiro artigo',
            'https://brunoviana.net/hello-world',
            new Autor('Bruno Viana'),
            new Data(2020, 01, 01),
            1,
            Artigo::LIDO
        );

        $this->assertEquals(1, $artigo->feedId());
    }
}
