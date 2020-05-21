<?php

namespace Usuario\App\UseCases;

use Usuario\Domain\Entities\Usuario;
use Usuario\Domain\Services\UsuarioService;
use Usuario\App\Requests\AutenticarUsuarioRequest;
use Usuario\App\Responses\AutenticarUsuarioResponse;

use Usuario\Domain\Repositories\UsuarioRepositoryInterface;
use Usuario\Domain\Interfaces\ConsultorDePermissoesInterface;

class AutenticarUsuario
{
    private $request;

    private $consultorDePermissoes;

    private $usuarioRepository;

    public function __construct(
        AutenticarUsuarioRequest $request,
        UsuarioRepositoryInterface $usuarioRepository,
        ConsultorDePermissoesInterface $consultorDePermissoes
    ) {
        $this->request = $request;
        $this->usuarioRepository = $usuarioRepository;
        $this->consultorDePermissoes = $consultorDePermissoes;
    }

    public function executar()
    {
        $usuario = $this->autenticar();

        return $this->responder($usuario);
    }

    public function autenticar()
    {
        $usuarioService = new UsuarioService();

        $usuarioService->setUsuarioRepository($this->usuarioRepository);
        $usuarioService->setConsultorDePermissoes($this->consultorDePermissoes);

        return $usuarioService->autenticaOuCriaUsuario(
            $this->request->nome(),
            $this->request->email()
        );
    }

    public function responder(Usuario $usuario)
    {
        return new AutenticarUsuarioResponse($usuario);
    }
}
