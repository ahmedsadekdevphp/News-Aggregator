<?php

namespace App\Http\Controllers\CroneJobs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\FetchNewsService;

class NewsFetchingController extends Controller
{
    public function fetchNews()
    {
        $newsProviders = config('newsproviders.providers');
        FetchNewsService::fetch($newsProviders);
    }
}
