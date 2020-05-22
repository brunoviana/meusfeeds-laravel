<?php

namespace Tests\Unit\Services;

use Tests\TestCase;

use App\Models\EmailPermitido;
use App\Services\ConsultorDePermissoes;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConsultorDePermissoesTest extends TestCase
{
    use RefreshDatabase;

    public function test_Deve_Retornar_True_Se_Email_Permitido_Com_Sucesso()
    {
        factory(EmailPermitido::class, 1)->create([
            'email' => 'brunoviana@gmail.com',
        ])->first();

        $consultorDePermissoes = new ConsultorDePermissoes();

        $this->assertTrue(
            $consultorDePermissoes->usuarioPodeSeAutenticar('brunoviana@gmail.com')
        );
    }

    public function test_Deve_Retornar_False_Se_Email_NAO_Permitido_Com_Sucesso()
    {
        $consultorDePermissoes = new ConsultorDePermissoes();

        $this->assertFalse(
            $consultorDePermissoes->usuarioPodeSeAutenticar('brunoviana@gmail.com')
        );
    }
}
