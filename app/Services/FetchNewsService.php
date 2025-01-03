<?php

namespace App\Services;

use App\Models\News;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class FetchNewsService
{
    /**
     * Fetches news from configured news providers.
     *It calls the `fetchProviderNews` method for each provider to retrieve
     * and handle the news data.
     *
     * The `fromDate` is set to 10 minutes ago, which will be used as the starting point for fetching news
     * published since that time.
     *@param array $newsProviders
     * @return void
     */
    public static function fetch($newsProviders)
    {
        $fromDate = now()->subMinutes(config('news.fetch_time_Frequency'));
        foreach ($newsProviders as $provider => $config) {
            self::fetchProviderNews($provider, $config, $fromDate);
        }
    }

    /**
     * Fetches news from a specific provider's API.
     * @param string $provider The name of the news provider.
     * @param array $config The configuration settings for the provider, including the URL, request body, and response path.
     * @param \Carbon\Carbon $fromDate The date from which to fetch news (typically set to 10 minutes ago).
     * @return void
     */
    private static function fetchProviderNews($provider, $config, $fromDate)
    {
        $config['request_body'][$config['date_key']] = $fromDate;
        try {
            $response = Http::withOptions([
                'verify' => false,
            ])->get($config['url'],  $config['request_body']);

            if ($response->successful()) {
                $data = data_get($response->json(), $config['response_path'], []);
                $newsData = self::formatResponse($data, $config);
                self::createNews($newsData, $provider);
            }
        } catch (\Exception $e) {
            Log::error("Error fetching news from {$provider}: " . $e->getMessage());
        }
    }



    /**
     * Formats the response data from the news provider into a structured format.
     *
     * This method iterates through the raw news data, transforming each item according
     * to the specified configuration. It maps the raw data fields to the appropriate
     * database fields and returns the formatted data ready for saving.
     *
     * @param array $data The raw data received from the news provider's API.
     * @param array $config The configuration settings that define how to map the raw data.
     * @return array The formatted news data.
     */
    private static function formatResponse($data, $config)
    {
        $newsData = [];
        foreach ($data as $key => $item) {
            $newsData[] = self::mapResponse($item, $config);
        }
        return $newsData;
    }

    /**
     * Maps API response data to database fields using a field mapping configuration.
     *
     * @param array $item An associative array representing the API response data.
     * @param array $config Configuration array containing a 'fields_map' key, which maps
     *                      API fields to their corresponding database fields.
     *
     * @return array Returns an array with database fields as keys and their corresponding
     *               values extracted from the API response. If a value is not found in
     *               the API response, it defaults to null.
     */
    private static function mapResponse(array $item, array $config): array
    {
        return collect($config['fields_map'])->mapWithKeys(function ($apiField, $dbField) use ($item) {
            return [$dbField => data_get($item, $apiField, null)];
        })->toArray();
    }

    /**
     * Creates or updates news entries in the database.
     *
     *
     * @param array $newsData The formatted news data to be saved in the database.
     * @param string $source The source from which the news was fetched.
     * @return void
     */
    private static function createNews($newsData, $source)
    {
        foreach ($newsData as $newsItem) {
            News::updateOrCreate(
                [
                    'title' => $newsItem['title'],
                    'url' => $newsItem['url'],
                    'published_at' => \Carbon\Carbon::parse($newsItem['published_at'])->format('Y-m-d H:i:s'),
                    'category' => $newsItem['category'] ?? config('news.Uncategorized'),
                    'type' => $newsItem['type']?? config('news.Unknown'),
                    'source_id' => $newsItem['source_id'],
                    'source' => $source,
                    'author' => $newsItem['author']?? config('news.Unknown')
                ]
            );
        }
    }
}
