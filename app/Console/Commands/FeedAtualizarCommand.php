<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mappers\FeedMapper;

use MeusFeeds\Feeds\App\UseCases\SincronizarFeed;
use App\Models\Feed as FeedModel;
use App\Services\BuscadorDeArtigos;
use App\Repositories\ArtigoRepository;

use MeusFeeds\Feeds\App\Requests\SincronizarFeedRequest;

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
