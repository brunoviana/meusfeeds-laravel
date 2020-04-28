<?php

namespace Framework\Console\Commands;

use App\Feed\UseCases\AtualizarFeed;
use App\Feed\Requests\AtualizarFeedRequest;

use Framework\Models\Feed as FeedModel;
use Framework\Adapters\Feed\BuscadorDeArtigosAdapter;
use Framework\Repositories\Feed\FeedRepositoryAdapter;

use Illuminate\Console\Command;

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
            $atualizaFeedRequest = new AtualizarFeedRequest($feedModel->id);
            $repositoryAdapter = app(FeedRepositoryAdapter::class);
            $buscadorDeArtigos = app(BuscadorDeArtigosAdapter::class);

            $atualizaFeed = new AtualizarFeed(
                $atualizaFeedRequest,
                $repositoryAdapter,
                $buscadorDeArtigos
            );

            $response = $atualizaFeed->executar();
            $feedAtualizado = $response->feed();

            $repositoryAdapter->save($feedAtualizado);
        }
        //
    }
}
