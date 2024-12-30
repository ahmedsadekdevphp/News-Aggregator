<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;

class FetchNewsService
{
    public static function fetch()
    {
        $fromDate = now()->subMinutes(10);
        $newsProviders = config('newsproviders.providers');
        foreach ($newsProviders as $provider => $config) {
            $config['request_body'][$config['date_key']] = $fromDate;
            $response = Http::withOptions([
                'verify' => false,
            ])->get($config['url'],  $config['request_body']);
            if ($response->successful()) {
                $data = data_get($response->json(), $config['response_path'], []);
                dd($data);
            }
        }
    }
}
