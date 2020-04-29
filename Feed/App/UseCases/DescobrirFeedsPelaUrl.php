<?php

namespace Feed\App\UseCases;

use Feed\Domain\Services\FeedService;
use Feed\Domain\Interfaces\ExtratorDeFeedsInterface;

use Feed\App\Requests\DescobrirFeedsPelaUrlRequest;
use Feed\App\Responses\DescobrirFeedsPelaUrlResponse;

class DescobrirFeedsPelaUrl
{
    private $request;

    private $extratorDeFeeds;

    public function __construct(
        DescobrirFeedsPelaUrlRequest $request,
        ExtratorDeFeedsInterface $extratorDeFeeds
    ) {
        $this->request = $request;
        $this->extratorDeFeeds = $extratorDeFeeds;
    }

    public function executar()
    {
        $feeds = $this->extrairFeeds();

        return $this->responder($feeds);
    }

    public function extrairFeeds()
    {
        $feedService = new FeedService();
        $feedService->setExtratorDeFeeds($this->extratorDeFeeds);

        return $feedService->procurarFeedsPelaUrl(
            $this->url()
        );
    }

    public function responder($feeds)
    {
        return new DescobrirFeedsPelaUrlResponse($feeds);
    }

    public function url()
    {
        return $this->request->url();
    }
}
