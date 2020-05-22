<?php

namespace Tests\Feature;

use Socialite;
use Tests\TestCase;
use MeusFeeds\Usuarios\App\UseCases\AutenticarUsuario;

use Illuminate\Foundation\Testing\RefreshDatabase;

class AutenticarUsuarioPeloGoogleTest extends TestCase
{
    use RefreshDatabase;

    public function test_Deve_Autenticar_Usuario_Com_Sucesso()
    {
        // $usuarioService = new AutenticarUsuario();

        $user = $this->mock(\Laravel\Socialite\Two\User::class, function ($mock) {
            $mock->name = 'Bruno Viana Arruda';
            $mock->email = 'brunoviana@gmail.com';
            $mock->avatar = 'https://lh3.googleusercontent.com/a-/AOh14GiV-6sGJocWh7ik0npt-7IaLlyjQAWF6EF17Y8rCaU';
        });

        $googleProvider = $this->mock(\Laravel\Socialite\Two\GoogleProvider::class, function ($mock) use ($user) {
            $mock->shouldReceive('user')
                ->andReturn($user);
        });

        $googleDriver = $this->mock(\Laravel\Socialite\Two\GoogleProvider::class, function ($mock) use ($googleProvider) {
            $mock->shouldReceive('stateless')
                ->andReturn($googleProvider);
        });

        Socialite::shouldReceive('driver')
                    ->once()
                    ->with('google')
                    ->andReturn($googleDriver);

        $params = [

        ];

        $response = $this->get('/callback-google', $params);

        $response->assertStatus(200);
    }
}
