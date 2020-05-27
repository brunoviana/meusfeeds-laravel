<?php

namespace Tests\Unit\Model;

use Tests\TestCase;

use App\Models\Convite;
use App\Models\ListaDeConvites;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListaDeConvitesTest extends TestCase
{
    use RefreshDatabase;

    public function test_Deve_Retornar_Email_Existe_Na_Lista_Com_Sucesso()
    {
        factory(Convite::class, 1)->create([
            'email' => 'brunoviana@gmail.com',
        ])->first();

        $listaDeConvites = new ListaDeConvites();

        $this->assertTrue(
            $listaDeConvites->emailExisteNaLista('brunoviana@gmail.com')
        );
    }

    public function test_Deve_Retornar_Email_NAO_Existe_Na_Lista_Com_Sucesso()
    {
        $listaDeConvites = new ListaDeConvites();

        $this->assertFalse(
            $listaDeConvites->emailExisteNaLista('brunoviana@gmail.com')
        );
    }
}
