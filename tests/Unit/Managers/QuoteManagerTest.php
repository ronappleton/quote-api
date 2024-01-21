<?php

declare(strict_types=1);

namespace Tests\Unit\Managers;

use App\Contracts\QuoteManager as QuoteManagerContract;
use App\Services\Quotes\QuoteManager;
use Tests\TestCase;

class QuoteManagerTest extends TestCase
{
    public function testManagerRegistered(): void
    {
        $manager = $this->app->make(QuoteManagerContract::class);

        self::assertInstanceOf(QuoteManager::class, $manager);
    }
}
