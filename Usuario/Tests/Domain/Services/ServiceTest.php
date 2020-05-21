<?php

namespace Usuario\Tests\Domain\Services;

use Tests\TestCase;
use Usuario\Domain\Services\Service;
use Usuario\Tests\TestAdapters\Domain\UsuarioRepositoryFake;
use Usuario\Tests\TestAdapters\Domain\ConsultorDePermissoesFake;

class ServiceTest extends TestCase
{
    protected $usuarioRepositoryFake;

    protected $consultorDePermissoesFake;

    public function setUp() : void
    {
        $this->usuarioRepositoryFake = new UsuarioRepositoryFake();
        $this->consultorDePermissoesFake = new ConsultorDePermissoesFake();
    }

    public function test_Deve_Setar_UsuarioRepository_Com_Sucesso()
    {
        $service = new Service();
        $service->setUsuarioRepository($this->usuarioRepositoryFake);

        $this->assertInstanceOf(UsuarioRepositoryFake::class, $service->getUsuarioRepository());
    }

    public function test_Deve_Retornar_Erro_Se_Nao_Tiver_UsuarioRepository()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Repositório de Usuario não foi setado.');

        $service = new Service();
        $service->getUsuarioRepository();
    }

    public function test_Deve_Setar_ConsultorDePermissoes_Com_Sucesso()
    {
        $service = new Service();
        $service->setConsultorDePermissoes($this->consultorDePermissoesFake);

        $this->assertInstanceOf(ConsultorDePermissoesFake::class, $service->getConsultorDePermissoes());
    }

    public function test_Deve_Retornar_Erro_Se_Nao_Tiver_ConsultorDePermissoes()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Consultor de Permissões não foi setado.');

        $service = new Service();
        $service->getConsultorDePermissoes();
    }
}
