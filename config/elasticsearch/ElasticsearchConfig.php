<?php

use Elasticsearch\ClientBuilder;

/**
 * Created by PhpStorm.
 * User: rok
 * Date: 2018. 7. 1.
 * Time: PM 2:27
 */

class ElasticsearchConfig
{
    public function getHost()
    {
        if (env('APP_ENV') == 'local') return 'http://localhost:9200';
    }

    public function getClient(){
        $hosts = [ $this->getHost() ];
        $client = ClientBuilder::create()
        ->setHosts($hosts)
        ->build();

        return $client;
    }
}