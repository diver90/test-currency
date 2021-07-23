<?php

namespace App\Console\Commands;

use App\Services\OpenExService;
use Illuminate\Console\Command;

class SaveCurrenciesList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currencies:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get currencies list from providers and save it into db';

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
        $data = dd($openExService->getCurrenciesList());
        return 0;
    }
}
