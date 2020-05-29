<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artigo as ArtigoModel;
use MeusFeeds\Feeds\App\UseCases\AlterarLidoDoArtigo;
use MeusFeeds\Feeds\App\Requests\AlterarLidoDoArtigoRequest;
use App\Repositories\ArtigoRepository;

class ArtigosController extends Controller
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
    public function store(Request $request)
    {
        //
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

    public function alterarLido(Request $request, ArtigoModel $artigo)
    {
        $alterarLido = new AlterarLidoDoArtigo(
            new AlterarLidoDoArtigoRequest(
                $artigo->id,
                $request->input('lido')
            ),
            new ArtigoRepository()
        );

        $alterarLido->executar();
    }
}
