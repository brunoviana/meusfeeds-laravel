<?php

namespace Usuario\Domain\Services;

use Usuario\Domain\Repositories\UsuarioRepositoryInterface;
use Usuario\Domain\Interfaces\ConsultorDePermissoesInterface;

class Service
{
    private $usuarioRepository;

    private $consultorDePermissoes;

    public function setUsuarioRepository(UsuarioRepositoryInterface $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function getUsuarioRepository() : UsuarioRepositoryInterface
    {
        if (!$this->usuarioRepository) {
            throw new \RuntimeException('Repositório de Usuario não foi setado.');
        }

        return $this->usuarioRepository;
    }

    public function setConsultorDePermissoes(ConsultorDePermissoesInterface $consultorDePermissoes)
    {
        $this->consultorDePermissoes = $consultorDePermissoes;
    }

    public function getConsultorDePermissoes() : ConsultorDePermissoesInterface
    {
        if (!$this->consultorDePermissoes) {
            throw new \RuntimeException('Consultor de Permissões não foi setado.');
        }

        return $this->consultorDePermissoes;
    }
}
