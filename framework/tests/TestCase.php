<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use DMS\PHPUnitExtensions\ArraySubset\Assert;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function makeMock($class, $assetions=null)
    {
        return $this->mock($class, $assetions);
    }

    public function makePartialMock($class, $assetions=null)
    {
        return $this->partialMock($class, $assetions);
    }

    public function getInstance($class)
    {
        return app($class);
    }

    public static function assertArraySubset($subset, $array, bool $checkForObjectIdentity = false, string $message = ''): void
    {
        Assert::assertArraySubset($subset, $array, $checkForObjectIdentity, $message);
    }
}
