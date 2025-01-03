<?php

namespace App\Http\Controllers\CroneJobs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\FetchNewsService;

class NewsFetchingController extends Controller
{
    /**
     * Fetch news from configured news providers.
     *
     * This method retrieves the list of news providers from the configuration file
     * and passes it to the `FetchNewsService` to fetch news data.
     *
     * @return void
     */
    public function fetchNews()
    {
        $newsProviders = config('newsproviders.providers');
        FetchNewsService::fetch($newsProviders);
    }
}
