<?php

namespace Tests\Unit\Mappers;

use Tests\TestCase;
use Framework\Mappers\UsuarioMapper;
// use Feed\Domain\ValueObjects\Data;

// use Feed\Domain\ValueObjects\Autor;
use Usuario\Domain\Entities\Usuario;

use Framework\Models\Usuario as UsuarioModel;

use Illuminate\Foundation\Testing\RefreshDatabase;

class UsuarioMapperTest extends TestCase
{
    use RefreshDatabase;

    public function test_Deve_Mapear_Entidade_Com_Sucesso()
    {
        $usuario = Usuario::novo(
            'Bruno Viana',
            'brunoviana@gmail.com'
        );

        $usuarioModel = UsuarioMapper::criaModel($usuario);

        $this->assertEquals('Bruno Viana', $usuarioModel->nome);
        $this->assertEquals('brunoviana@gmail.com', $usuarioModel->email);
    }

    public function test_Deve_Retornar_Entitade_Corretamente()
    {
        $usuarioModel = new UsuarioModel();
        $usuarioModel->nome = 'Bruno Viana';
        $usuarioModel->email = 'brunoviana@gmail.com';

        $usuario = UsuarioMapper::criaEntidade($usuarioModel);

        $this->assertEquals('Bruno Viana', $usuario->nome());
        $this->assertEquals('brunoviana@gmail.com', $usuario->email());
    }
}
