<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use App\Models\Usuario as UsuarioModel;
use App\Models\Convite;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AutenticarUsuarioTest extends TestCase
{
    use RefreshDatabase;

    public function test_Deve_Autenticar_Usuario_Existente_Com_Sucesso()
    {
        $usuario = factory(UsuarioModel::class, 1)->create([
            'nome' => 'Bruno Viana',
            'email' => 'brunoviana@gmail.com'
        ])->first();

        $params = [
            'nome' => 'Bruno Viana',
            'email' => 'brunoviana@gmail.com'
        ];

        $response = $this->post('/api/auth/login', $params);

        $response->assertStatus(200)
                ->assertHeader('Authorization')
                ->assertJsonFragment([
                    'status' => 'success'
                ]);

        $this->assertEquals(
            $usuario->toArray(),
            auth()->user()->toArray()
        );
    }

    public function test_Deve_Autenticar_Usuario_Com_Convite_Com_Sucesso()
    {
        $usuario = factory(Convite::class, 1)->create([
            'email' => 'brunoviana@gmail.com'
        ])->first();

        $params = [
            'nome' => 'Bruno Viana',
            'email' => 'brunoviana@gmail.com'
        ];

        $response = $this->post('/api/auth/login', $params);

        $response->assertStatus(200)
                ->assertHeader('Authorization')
                ->assertJsonFragment([
                    'status' => 'success'
                ]);

        $this->assertEquals('Bruno Viana', auth()->user()->nome);
        $this->assertEquals('brunoviana@gmail.com', auth()->user()->email);
    }

    public function test_Deve_Falhar_Se_Usuario_Nao_For_Autenticado()
    {
        $params = [
            'nome' => 'Bruno Viana',
            'email' => 'brunoviana@gmail.com'
        ];

        $response = $this->post('/api/auth/login', $params);

        $response->assertStatus(401)
                ->assertJsonFragment([
                    'error' => 'Usuário não tem permissão para acessar'
                ]);
    }
}
