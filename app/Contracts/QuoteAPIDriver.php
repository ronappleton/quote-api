<?php

namespace App\Contracts;

interface QuoteAPIDriver
{
    /**
     * Get quotes from API
     *
     * @return array<int, string>
     */
    public function getQuotes(int $count =1): array;
}
