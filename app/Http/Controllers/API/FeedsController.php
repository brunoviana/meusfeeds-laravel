<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use MeusFeeds\Feeds\App\UseCases\CriarNovoFeed;
use App\Models\Feed as FeedModel;

use App\Services\ExtratorDeFeeds;
use App\Services\BuscadorDeArtigos;
use App\Http\Controllers\Controller;
use App\Repositories\FeedRepository;
use MeusFeeds\Feeds\App\Requests\CriarNovoFeedRequest;
use App\Repositories\ArtigoRepository;
use App\Http\Resources\Feed\FeedResource;
use MeusFeeds\Feeds\Domain\Exceptions\FeedJaExisteException;

use App\Http\Resources\Feed\FeedsDescobertosResource;

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

        $criarFeed = new CriarNovoFeed(
            $criarFeedRequest,
            app(FeedRepository::class),
            app(ArtigoRepository::class),
            app(BuscadorDeArtigos::class)
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
        $extratorDeFeeds = app(ExtratorDeFeeds::class);

        $feeds = $extratorDeFeeds->extrair(
            $request->input('url')
        );

        return (new FeedsDescobertosResource(collect($feeds)))
                    ->response()
                    ->setStatusCode(200);
    }
}
