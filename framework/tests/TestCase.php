<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function makeMock($class, $assetions)
    {
        return $this->mock($class, $assetions);
    }

    public function getInstance($class)
    {
        return app($class);
    }
}
