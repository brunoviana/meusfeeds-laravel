<?php

namespace Usuario\Tests\App\UseCases;

use Tests\TestCase;

use Usuario\Domain\Entities\Usuario;
use Usuario\App\UseCases\AutenticarUsuario;
use Usuario\App\Requests\AutenticarUsuarioRequest;
use Usuario\App\Responses\AutenticarUsuarioResponse;

use Usuario\Tests\TestAdapters\Domain\UsuarioRepositoryFake;
use Usuario\Tests\TestAdapters\Domain\ConsultorDePermissoesFake;

class AutenticarUsuarioTest extends TestCase
{
    protected $usuarioRepositoryFake;

    protected $consultorDePermissoesFake;

    public function setUp() : void
    {
        $this->usuarioRepositoryFake = new UsuarioRepositoryFake();
        $this->consultorDePermissoesFake = new ConsultorDePermissoesFake();
    }

    public function test_Deve_Autenticar_Usuario_Com_Sucesso()
    {
        $autenticarUsuario = new AutenticarUsuario(
            new AutenticarUsuarioRequest(
                'Bruno Viana',
                'brunoviana@gmail.com'
            ),
            $this->usuarioRepositoryFake,
            $this->consultorDePermissoesFake
        );

        $resposta = $autenticarUsuario->executar();

        $this->assertInstanceOf(AutenticarUsuarioResponse::class, $resposta);
        $this->assertInstanceOf(Usuario::class, $resposta->usuario());
        $this->assertEquals(1, $resposta->usuario()->id());
        $this->assertEquals('Bruno Viana', $resposta->usuario()->nome());
        $this->assertEquals('brunoviana@gmail.com', $resposta->usuario()->email());
    }
}
