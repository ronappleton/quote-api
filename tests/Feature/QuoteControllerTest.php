<?php

declare(strict_types=1);

namespace Feature;

use App\Models\Quote;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class QuoteControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        Config::set('auth.api_token', 'test-token');

        $this->createQuotesAndCache();
    }

    private function createQuotesAndCache(): void
    {
        Cache::flush();

        $quotes = [
            'This is a test quote',
            'This is another test quote',
            'This is a third test quote',
            'This is a fourth test quote',
            'This is a fifth test quote',
            'This is a sixth test quote',
            'This is a seventh test quote',
            'This is a eighth test quote',
            'This is a ninth test quote',
            'This is a tenth test quote',
        ];

        Quote::insert(array_map(function ($quote) {
            return ['quote' => $quote];
        }, $quotes));

        Cache::rememberForever('quotes', function () {
            return Quote::all()->pluck('quote')->toArray();
        });
    }

    public function testUnauthorised(): void
    {
        $response = $this->getJson('/api/quotes');

        $response->assertStatus(401);
    }

    public function testAuthorised(): void
    {
        $response = $this->getJson('/api/quotes?api_token=' . config('auth.api_token'));

        $response->assertStatus(200);
    }

    public function testQuoteStructure(): void
    {
        $response = $this->getJson('/api/quotes?api_token=' . config('auth.api_token'));

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'quote',
                ],
            ],
        ]);
    }

    public function testQuoteCount(): void
    {
        $response = $this->getJson('/api/quotes?api_token=' . config('auth.api_token'));

        $response->assertJsonCount(5, 'data');
    }

    public function testQuotesChangeOnRefresh(): void
    {
        $response = $this->getJson('/api/quotes?api_token=' . config('auth.api_token'));

        $quotesOne = $response->json();

        self::assertCount(5, $quotesOne['data']);

        $response = $this->getJson('/api/quotes?api_token=' . config('auth.api_token'));

        $quotesTwo = $response->json();

        self::assertCount(5, $quotesTwo['data']);

        self::assertNotEquals($quotesOne, $quotesTwo);
    }
}
