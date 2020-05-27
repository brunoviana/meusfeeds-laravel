<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;

use MeusFeeds\Usuarios\Domain\Entities\Usuario;
use App\Models\Usuario as UsuarioModel;

use App\Repositories\UsuarioRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsuarioRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_Deve_Buscar_Usuario_Pelo_Email()
    {
        factory(UsuarioModel::class, 1)->create([
            'nome' => 'Bruno Viana',
            'email' => 'brunoviana@gmail.com'
        ]);

        $repository = new UsuarioRepository();
        $usuario = $repository->buscarPeloEmail('brunoviana@gmail.com');

        $this->assertInstanceOf(Usuario::class, $usuario);
        $this->assertEquals('Bruno Viana', $usuario->nome());
    }

    public function test_Deve_Retornar_Nulo_Se_Nao_Achar_Usuario_Pelo_Email()
    {
        $repository = new UsuarioRepository();
        $usuario = $repository->buscarPeloEmail('brunoviana@gmail.com');

        $this->assertNull($usuario);
    }

    public function test_Deve_Salvar_Usuario_Com_Sucesso()
    {
        $usuario = new Usuario(
            'Bruno Viana',
            'brunoviana@gmail.com'
        );

        $repository = new UsuarioRepository();
        $repository->salvar($usuario);

        $this->assertCount(1, UsuarioModel::all());
    }

    public function test_Deve_Setar_Id_Do_Usuario_Ao_Salvar()
    {
        $usuario = new Usuario(
            'Bruno Viana',
            'brunoviana@gmail.com'
        );

        $repository = new UsuarioRepository();
        $repository->salvar($usuario);

        $this->assertEquals(1, $usuario->id());
    }
}
