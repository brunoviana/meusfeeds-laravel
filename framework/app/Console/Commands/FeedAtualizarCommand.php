<?php

namespace Framework\Console\Commands;

use Illuminate\Console\Command;
use Framework\Mappers\FeedMapper;

use Feed\App\UseCases\SincronizarFeed;
use Framework\Models\Feed as FeedModel;
use Framework\Services\BuscadorDeArtigos;
use Framework\Repositories\ArtigoRepository;

use Feed\App\Requests\SincronizarFeedRequest;

class FeedAtualizarCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:atualizar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza lista de artigos dos feeds cadastrados';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (FeedModel::all() as $feedModel) {
            $sincronizarFeedRequest = new SincronizarFeedRequest(
                FeedMapper::criaEntidade($feedModel)
            );

            $artigoRepository = app(ArtigoRepository::class);
            $buscadorDeArtigos = app(BuscadorDeArtigos::class);

            $sincronizarFeed = new SincronizarFeed(
                $sincronizarFeedRequest,
                $artigoRepository,
                $buscadorDeArtigos
            );

            $sincronizarFeed->executar();
        }
    }
}
