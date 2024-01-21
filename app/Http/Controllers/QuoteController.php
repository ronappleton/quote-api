<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\QuoteResource;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class QuoteController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $quotes = Cache::get('quotes');

        shuffle($quotes);
        $quotes = array_slice($quotes, 0, 5);

        return QuoteResource::collection($quotes);
    }
}
