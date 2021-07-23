<?php

namespace App\Console\Commands;

use App\Models\Rate;
use App\Services\OpenExService;
use Illuminate\Console\Command;

class SaveCurrecies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currencies:load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get currencies latest rates from providers and save it into db';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(OpenExService $openExService)
    {
        $data = $openExService->getLastRates();

        $rates = $this->mapRates($data['rates'], $data['timestamp']);

        foreach ($rates as $rate) {
            Rate::create($rate);
        }

        return 0;
    }

    private function mapRates($data, $timestamp)
    {
        $mapped = [];
        foreach ($data as $symbol => $rate) {
            $mapped[] = [
                'symbol' => $symbol,
                'rate' => $rate,
                'timestamp' => $timestamp
            ];
        }
        return $mapped;
    }
}
