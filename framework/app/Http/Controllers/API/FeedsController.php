<?php

namespace Framework\Http\Controllers\API;

use Domain\Feed\Entities\Feed;

use App\Feed\UseCases\CriarNovoFeed;
use App\Feed\Requests\CriarNovoFeedRequest;
use App\Feed\Exceptions\FeedJaExisteException;

use App\Feed\Requests\DescobrirFeedsPelaUrlRequest;
use App\Feed\UseCases\DescobrirFeedsPelaUrl;

use Framework\Http\Controllers\Controller;
use Framework\Models\Feed as FeedModel;
use Framework\Adapters\Feed\Repositories\FeedRepositoryAdapter;
use Framework\Adapters\Feed\Services\BuscadorDeFeedsService;
use Framework\Http\Resources\Feed\FeedResource;
use Framework\Http\Resources\Feed\FeedsDescobertosResource;

use Illuminate\Http\Request;

class FeedsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $httpRequest)
    {
        $criarFeedRequest = new CriarNovoFeedRequest(
            $httpRequest->input('titulo'),
            $httpRequest->input('link_rss')
        );

        $feedRepositoryAdapter = new FeedRepositoryAdapter();

        $criarFeed = new CriarNovoFeed(
            $criarFeedRequest,
            $feedRepositoryAdapter
        );

        try {
            $criarFeedResponse = $criarFeed->executar();

            $feed = $criarFeedResponse->feed();

            return (new FeedResource(
                FeedModel::find($feed->id())
            ))
            ->response()
            ->setStatusCode(201);
        } catch (FeedJaExisteException $e) {
            return response()->json([
                'message' => 'Este feed já está cadastrado'
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function descobrir(Request $request)
    {
        $descobrirFeedsRequest = new DescobrirFeedsPelaUrlRequest(
            $request->input('url')
        );

        $buscadorDeFeed = app(BuscadorDeFeedsService::class);

        $descobrirFeeds = new DescobrirFeedsPelaUrl(
            $descobrirFeedsRequest,
            $buscadorDeFeed
        );

        $response = $descobrirFeeds->executar();

        $feeds = $response->feeds();

        return (new FeedsDescobertosResource(collect($feeds)))
                    ->response()
                    ->setStatusCode(200);
    }
}
