<?php

namespace Usuario\Domain\Services;

use Usuario\Domain\Entities\Usuario;
use Usuario\Domain\Exceptions\EmailNaoPermitidoExcetion;

class UsuarioService extends Service
{
    public function autenticaOuCriaUsuario(string $nome, string $email) : Usuario
    {
        if (!$this->getConsultorDePermissoes()->usuarioPodeSeAutenticar($email)) {
            throw new EmailNaoPermitidoExcetion('Email do usuário não tem permissão para fazer login.');
        }

        $usuario = $this->getUsuarioRepository()->buscarPeloEmail($email);

        if (!$usuario) {
            $usuario = Usuario::novo($nome, $email);

            $this->getUsuarioRepository()->salvar($usuario);
        }

        return $usuario;
    }
}
