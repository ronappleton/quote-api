<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Quote;
use App\Services\Quotes\QuoteManager;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Console\Command\Command as CommandAlias;

class WarmQuoteCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quotes:cache {--count=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pre Cache Quotes';

    /**
     * Number of quotes to cache.
     */
    private int $count = 100;

    /**
     * Execute the console command.
     */
    public function handle(QuoteManager $manager): int
    {
        $count = $this->option('count') ?? $this->count;

        try {
            $this->info('Warming quote cache...');

            $bar = $this->output->createProgressBar($count);

            $bar->start();

            for ($i = 0; $i < $count; $i++) {
                $quote = $manager->driver(config('quotes.driver'))->getQuotes(1);
                Quote::updateOrInsert(['quote' => reset($quote)]);
                usleep(100 * 1000); // 100ms
                $bar->advance();
            }

            $bar->finish();
            $this->output->newLine();

            Cache::rememberForever('quotes', function () {
                return Quote::all()->pluck('quote')->toArray();
            });

            return CommandAlias::SUCCESS;
        } catch (\Throwable $e) {
            $this->error($e->getMessage());

            return CommandAlias::FAILURE;
        }
    }
}
