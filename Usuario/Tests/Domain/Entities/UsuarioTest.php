<?php

namespace Usuario\Tests\Domain\Entities;

use Usuario\Domain\Entities\Usuario;

use Tests\TestCase;

class UsuarioTest extends TestCase
{
    public function test_Novo_Usuario_Deve_Comecar_Com_Id_Zero()
    {
        $usuario = Usuario::novo(
            'Bruno Viana',
            'brunoviana@gmail.com',
            '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        );
        
        $this->assertEquals(0, $usuario->id());
    }

    public function test_Novo_Usuario_Deve_Inserir_Id_Com_Sucesso()
    {
        $usuario = Usuario::novo(
            'Bruno Viana',
            'brunoviana@gmail.com',
            '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        );
        
        $usuario->id(1);
        
        $this->assertEquals(1, $usuario->id());
    }

    public function test_Deve_Falhar_Setar_Id_Do_Usuario_Se_Ja_Tiver_Id()
    {
        $this->expectException(\RuntimeException::class);

        $usuario = Usuario::novo(
            'Bruno Viana',
            'brunoviana@gmail.com',
            '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        );
        
        $usuario->id(1);
        $usuario->id(2);
    }

    public function test_Usuario_Deve_Retornar_Nome_Correto()
    {
        $usuario = Usuario::novo(
            'Bruno Viana',
            'brunoviana@gmail.com',
            '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        );
        
        $this->assertEquals('Bruno Viana', $usuario->titulo());
    }

    public function test_Usuario_Deve_Retornar_Email_Correto()
    {
        $usuario = Usuario::novo(
            'Bruno Viana',
            'brunoviana@gmail.com',
            '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        );
        
        $this->assertEquals('brunoviana@gmail.com', $usuario->email());
    }

    public function test_Usuario_Deve_Retornar_Hash_Da_Senha_Correto()
    {
        $usuario = Usuario::novo(
            'Bruno Viana',
            'brunoviana@gmail.com',
            '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        );
        
        $this->assertEquals('$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', $usuario->hashSenha());
    }
}
