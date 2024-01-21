<?php

declare(strict_types=1);

namespace Feature;

use Http;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class WarmQuoteCacheTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        Http::fake([
            '*' => Http::response([
                'quote' => 'This is a test quote',
            ]),
        ]);

        Cache::flush();
    }

    public function testWarmQuoteCache(): void
    {
        Artisan::call('quotes:cache', ['--count' => 1]);

        self::assertDatabaseHas('quotes', [
            'quote' => 'This is a test quote',
        ]);
    }

    public function testCacheHoldQuote(): void
    {
        Artisan::call('quotes:cache', ['--count' => 1]);

        $quotes = Cache::get('quotes');

        self::assertCount(1,  $quotes);
    }
}
