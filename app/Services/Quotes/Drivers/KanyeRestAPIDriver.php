<?php

declare(strict_types=1);

namespace App\Services\Quotes\Drivers;

use App\Abstracts\QuoteAPIDriver;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class KanyeRestAPIDriver extends QuoteAPIDriver
{
    public function __construct(private readonly string $url = 'https://api.kanye.rest')
    {
    }

    /**
     * @return array<int, string>
     */
    public function getQuotes(int $count = 1): array
    {
        return $this->makeRequest($this->url, $count);
    }
}
