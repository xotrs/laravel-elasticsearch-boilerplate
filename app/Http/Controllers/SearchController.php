<?php
/**
 * Created by PhpStorm.
 * User: rok
 * Date: 2018. 6. 13.
 * Time: PM 3:59
 */

namespace App\Http\Controllers;

use ElasticsearchConfig;

class SearchController
{
    private $elasticsearchConfig;

    /**
     * SearchController constructor.
     * @param ElasticsearchConfig $elasticsearchConfig
     */
    public function __construct(ElasticsearchConfig $elasticsearchConfig)
    {
        $this->elasticsearchConfig = $elasticsearchConfig;
    }

    public function search($keyword)
    {
        $params = [
            'index' => 'board',
            'type' => 'v1',
            'body' => [
                'query' => [
                    'multi_match' => [
                        'query' => $keyword,
                        'fields' => ['title', 'content'],
                        'operator' => 'AND'
                    ]
                ]
            ]
        ];

        $result = $this->elasticsearchConfig->getClient()->search($params);
        $boards = [];

        foreach($result['hits']['hits'] as $board)
        {
            array_push($boards, $board['_source']);
        }

        return response()->json($boards);
    }
}