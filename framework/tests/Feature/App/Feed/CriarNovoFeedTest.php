<?php

namespace Tests\Feature\App\Feed;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Feature\App\Feed\Adapters\TesteFeedRepository;

use App\Feed\UseCases\CriarNovoFeed;
use App\Feed\Requests\CriarNovoFeedRequest;
use App\Feed\Exceptions\FeedJaExisteException;

class CriarNovoFeedTest extends TestCase
{
    protected $feedRepository;

    protected function setUp() : void
    {
        $this->feedRepository = new TesteFeedRepository();
    }

    public function test_Deve_Criar_Novo_Feed_Com_Sucesso()
    {
        $request = new CriarNovoFeedRequest('Novo Feed', 'https://brunoviana.dev/rss.xml');
        $criarFeed = new CriarNovoFeed($request, $this->feedRepository);

        $this->assertTrue(
            $criarFeed->executar()
        );
    }

    public function test_Deve_Validar_Feed_Ja_Existente()
    {
        $this->expectException(FeedJaExisteException::class);

        $request = new CriarNovoFeedRequest('Novo Feed', 'https://brunoviana.dev/rss.xml');

        $criarFeed = new CriarNovoFeed($request, $this->feedRepository);
        $criarFeed->executar();

        $criarFeedRepetido = new CriarNovoFeed($request, $this->feedRepository);
        $criarFeedRepetido->executar();
    }
}
