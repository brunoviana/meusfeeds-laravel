<?php

namespace Tests\Feature\App\Feed\UseCases;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Feed\Tests\UseCase\CriarNovoFeedTest as CriarNovoFeedTestTrait;

class CriarNovoFeedTest extends TestCase
{
    use CriarNovoFeedTestTrait;
}
