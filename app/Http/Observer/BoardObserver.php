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
    protected $elasticsearchConfig;

    /**
     * BoardObserver constructor.
     * @param ElasticsearchConfig $elasticsearchConfig
     */
    public function __construct(ElasticsearchConfig $elasticsearchConfig)
    {
        $this->elasticsearchConfig = $elasticsearchConfig;
    }

    public function updated(Board $board)
    {
        $params = [
            'index' => 'board',
            'type' => 'v1',
            'id' => $board['id'],
            'body' => $board
        ];

        return $this->elasticsearchConfig->getClient()->index($params);
    }

    public function created(Board $board)
    {
        $params = [
            'index' => 'board',
            'type' => 'v1',
            'id' => $board['id'],
            'body' => $board
        ];

        return $this->elasticsearchConfig->getClient()->index($params);
    }

    public function deleted(Board $board)
    {
        $params = [
            'index' => 'board',
            'type' => 'v1',
            'id' => $board['id']
        ];

        if($this->elasticsearchConfig->getClient()->exists($params))
        {
            return $this->elasticsearchConfig->getClient()->delete($params);
        }else{
            return false;
        }
    }

}