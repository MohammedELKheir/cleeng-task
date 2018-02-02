<?php

namespace App\Application\Console\Commands;

use App\Infrastructure\Service\ServerStatisticsService;
use Illuminate\Console\Command;

class generateStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statistics:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generating statistics';

    /**
     * serverStatistics service to persist statistics in database
     *
     * @var serverStatisticsService
     */
    protected $ServerStatisticsService;

    /**
     * Create a new command instance.
     *
     * @param  ServerStatisticsService  $ServerStatisticsService
     * @return void
     */
    public function __construct(ServerStatisticsService $ServerStatisticsService)
    {
        parent::__construct();

        $this->ServerStatisticsService = $ServerStatisticsService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->ServerStatisticsService->serverStatisticsGenerator();

        $this->info(sprintf(' statistics generated successfully '));
    }
}