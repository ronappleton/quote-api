<?php

declare(strict_types=1);

namespace App\Services\Quotes;

use App\Contracts\QuoteAPIDriver;
use App\Exceptions\QuoteAPIDriverNotFound;
use App\Services\Quotes\Drivers\KanyeRestAPIDriver;
use Illuminate\Support\Manager;

class QuoteManager extends Manager
{
    public function createKanyeRestAPIDriver(): QuoteAPIDriver
    {
        return new KanyeRestAPIDriver;
    }

    public function getDefaultDriver(): void
    {
        throw new QuoteAPIDriverNotFound('No quote API driver was specified.');
    }
}
