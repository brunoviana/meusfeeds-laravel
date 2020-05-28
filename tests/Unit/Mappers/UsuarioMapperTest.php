<?php

namespace Tests\Unit\Mappers;

use Tests\TestCase;
use App\Mappers\UsuarioMapper;
// use MeusFeeds\Feeds\Domain\ValueObjects\Data;

// use MeusFeeds\Feeds\Domain\ValueObjects\Autor;
use MeusFeeds\Usuarios\Domain\Entities\Usuario;

use App\Models\Usuario as UsuarioModel;

use Illuminate\Foundation\Testing\RefreshDatabase;

class UsuarioMapperTest extends TestCase
{
    use RefreshDatabase;

    public function test_Deve_Mapear_Entidade_Com_Sucesso()
    {
        $usuario = new Usuario(
            'Bruno Viana',
            'brunoviana@gmail.com',
            'foto.jpg'
        );

        $usuarioModel = UsuarioMapper::criaModel($usuario);

        $this->assertEquals('Bruno Viana', $usuarioModel->nome);
        $this->assertEquals('brunoviana@gmail.com', $usuarioModel->email);
        $this->assertEquals('foto.jpg', $usuarioModel->foto);
    }

    public function test_Deve_Retornar_Entitade_Corretamente()
    {
        $usuarioModel = new UsuarioModel();
        $usuarioModel->nome = 'Bruno Viana';
        $usuarioModel->email = 'brunoviana@gmail.com';
        $usuarioModel->foto = 'foto.jpg';

        $usuario = UsuarioMapper::criaEntidade($usuarioModel);

        $this->assertEquals('Bruno Viana', $usuario->nome());
        $this->assertEquals('brunoviana@gmail.com', $usuario->email());
        $this->assertEquals('foto.jpg', $usuario->foto());
    }
}
