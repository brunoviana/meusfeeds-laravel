<?php

namespace Framework\FeedIo;

use FeedIo\Explorer as ExplorerParent;

class Explorer extends ExplorerParent
{
    public function discover(string $url) : array
    {
        $contents = file_get_contents($url);

        $internalErrors = libxml_use_internal_errors(true);
        $entityLoaderDisabled = libxml_disable_entity_loader(true);

        $feeds = $this->extractFeeds($contents);

        libxml_use_internal_errors($internalErrors);
        libxml_disable_entity_loader($entityLoaderDisabled);

        return $feeds;
    }
}
