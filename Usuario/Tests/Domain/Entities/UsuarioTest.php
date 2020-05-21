<?php

namespace Usuario\Tests\Domain\Entities;

use Tests\TestCase;

use Usuario\Domain\Entities\Usuario;

class UsuarioTest extends TestCase
{
    public function test_Novo_Usuario_Deve_Comecar_Com_Id_Zero()
    {
        $usuario = Usuario::novo(
            'Bruno Viana',
            'brunoviana@gmail.com'
        );

        $this->assertEquals(0, $usuario->id());
    }

    public function test_Novo_Usuario_Deve_Inserir_Id_Com_Sucesso()
    {
        $usuario = Usuario::novo(
            'Bruno Viana',
            'brunoviana@gmail.com'
        );

        $usuario->id(1);

        $this->assertEquals(1, $usuario->id());
    }

    public function test_Deve_Falhar_Setar_Id_Do_Usuario_Se_Ja_Tiver_Id()
    {
        $this->expectException(\RuntimeException::class);

        $usuario = Usuario::novo(
            'Bruno Viana',
            'brunoviana@gmail.com'
        );

        $usuario->id(1);
        $usuario->id(2);
    }

    public function test_Usuario_Deve_Retornar_Nome_Correto()
    {
        $usuario = Usuario::novo(
            'Bruno Viana',
            'brunoviana@gmail.com'
        );

        $this->assertEquals('Bruno Viana', $usuario->nome());
    }

    public function test_Usuario_Deve_Retornar_Email_Correto()
    {
        $usuario = Usuario::novo(
            'Bruno Viana',
            'brunoviana@gmail.com'
        );

        $this->assertEquals('brunoviana@gmail.com', $usuario->email());
    }
}
