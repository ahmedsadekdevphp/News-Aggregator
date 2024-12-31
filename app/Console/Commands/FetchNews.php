<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Http\Controllers\CroneJobs\NewsFetchingController;

class FetchNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the latest news from different sources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $controller = new NewsFetchingController();
        $controller->fetchNews();

        $this->info('News fetching completed successfully!');
    }
}
