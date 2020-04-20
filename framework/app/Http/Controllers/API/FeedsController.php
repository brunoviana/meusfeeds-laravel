<?php

namespace Framework\Http\Controllers\API;

use Illuminate\Http\Request;

use Framework\Http\Controllers\Controller;
use Framework\Models\Feed as FeedModel;
use Framework\Adapters\Repositories\FeedRepositoryAdapter;
use Framework\Http\Resources\Feed as FeedResource;

use App\Feed\UseCases\CriarNovoFeed;
use App\Feed\Requests\CriarNovoFeedRequest;
use App\Feed\Responses\CriarNovoFeedResponse;
use App\Feed\Exceptions\FeedJaExisteException;

use Domain\Feed\Entities\Feed;

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

        $criarFeed = new CriarNovoFeed($criarFeedRequest, $feedRepositoryAdapter);

        $criarFeedResponse = $criarFeed->executar();
        $feed = $criarFeedResponse->feed();

        return (new FeedResource(
            FeedModel::find($feed->id())
        ))
        ->response()
        ->setStatusCode(201);
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
}
