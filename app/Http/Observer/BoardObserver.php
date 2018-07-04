<?php
/**
 * Created by PhpStorm.
 * User: rok
 * Date: 2018. 7. 1.
 * Time: PM 8:14
 */

namespace App\Http\Observer;


use App\Board;
use ElasticsearchConfig;

class BoardObserver
{
    protected $elasticsearchClient;

    /**
     * BoardObserver constructor.
     * @param $elasticsearchClient
     */
    public function __construct(ElasticsearchConfig $elasticsearchClient)
    {
        $this->elasticsearchClient = new ElasticsearchConfig();
    }

    public function updated(Board $board)
    {
//        $params = [
//            'index' => 'board',
//            'type' => 'v1',
//            'id' => $board['id'],
//            'body' => $board
//        ];
//
//        return $this->elasticsearchClient->getClient()->index($params);
    }

}