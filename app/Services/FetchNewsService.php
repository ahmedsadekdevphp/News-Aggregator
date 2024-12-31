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
                self::formatResponse($data,$provider,$config);
            }
        }
    }

    private static function formatResponse($data,$provider, $config)
    {
        $newsData = [];
        foreach ($data as $key => $item) {
            $newsData[] = self::mapResponse($item, $config);
        }
        return $newsData;
    }

    private static function mapResponse(array $item, array $config): array
    {
        return collect($config['fields_map'])->mapWithKeys(function ($apiField, $dbField) use ($item) {
            return [$dbField => data_get($item, $apiField, null)];
        })->toArray();
    }

}
