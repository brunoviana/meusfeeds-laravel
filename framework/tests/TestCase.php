<?php

namespace Tests;

use DMS\PHPUnitExtensions\ArraySubset\Assert;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

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
