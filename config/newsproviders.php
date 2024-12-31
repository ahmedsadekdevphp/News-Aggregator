<?php
return [
    'providers' => [
        'nytimes' => [
            'url' => 'https://api.nytimes.com/svc/search/v2/articlesearch.json',
            'date_key' => 'begin_date',
            'request_body' => [
                'begin_date' => '',
                'api-key' => 'uY7e9Nqy43NpItFAV9IkJ0kMTQDMF0u0',
            ],
            'response_path' => 'response.docs',
            'fields_map' => [
                'title' => 'headline.main',
                'url' => 'web_url',
                'publised_at' => 'pub_date',
                'category' => 'section_name',
                'type' => 'type_of_material',
                'source_id' => '_id',
                'author' => 'byline.original'
            ],

        ],
        'guardian' => [
            'url' => 'https://content.guardianapis.com/search',
            'date_key' => 'from-date',
            'request_body' => [
                'from-date' => '',
                'type' => 'article',
                'api-key' => '917a9ace-40e4-413a-83ef-825a74ed6b6b',
            ],
            'response_path' => 'response.results',
            'fields_map' => [
                'title' => 'webTitle',
                'url' => 'webUrl',
                'publised_at' => 'webPublicationDate',
                'category' => 'sectionName',
                'type' => 'pillarName',
                'source_id' => 'id',
                'author' => ''
            ],
        ],
        'newsapi' => [
            'url' => 'https://newsapi.org/v2/top-headlines',
            'date_key' => 'from',
            'request_body' => [
                'country' => 'us',
                'from' => '',
                'apiKey' => 'c35b92d86d864b288b3be8a5044fbf6f',
            ],
            'response_path' => 'articles',
            'fields_map' => [
                'title' => 'title',
                'url' => 'url',
                'publised_at' => 'publishedAt',
                'category' => 'sectionName',
                'type' => '',
                'source_id' => '',
                'author' => 'author'
            ],
        ],
    ],

];
