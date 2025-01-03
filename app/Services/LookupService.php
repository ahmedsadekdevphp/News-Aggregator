<?php

namespace App\Services;

use App\Models\News;
use Illuminate\Support\Facades\Cache;

class LookupService
{

    /**
     * Retrieve preference lookup data for categories, sources, and authors.
     *
     * @return array Associative array with keys 'categories', 'sources', and 'authors',
     *               each containing their respective lookup data.
     */
    public static function getPreferencesLookups()
    {
        return [
            'categories' => self::getCategories(),
            'sources' => self::getSources(),
            'authors' => self::getAuthors()
        ];
    }

    /**
     * Retrieve search lookup data for categories and sources.
     * @return array Associative array with keys 'categories' and 'sources',
     *               each containing their respective lookup data.
     */
    public static function getSearchLookups()
    {
        return [
            'categories' => self::getCategories(),
            'sources' => self::getSources(),
        ];
    }

    /**
     * Retrieve distinct news sources.
     * @return array An array of distinct news sources.
     */
    public static function getSources()
    {
        return  Cache::remember('sources', config('news.cache_expiration_time'), function () {
            return News::distinct()->pluck('source')->toArray();
        });
    }


    /**
     * Retrieve distinct news categories.
     * @return array An array of distinct news categories.
     */
    public static function getCategories()
    {
        return Cache::remember('categories', config('news.cache_expiration_time'), function () {
            return News::distinct()->pluck('category')->toArray();
        });
    }
    /**
     * Retrieve distinct news authors with caching.
     * @return array An array of distinct news authors.
     */
    public static function getAuthors()
    {
        return Cache::remember('authors', config('news.cache_expiration_time'), function () {
            return News::distinct()->pluck('author')->toArray();
        });
    }
}
