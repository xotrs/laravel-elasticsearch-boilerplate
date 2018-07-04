<?php

namespace App\Providers;

use App\Board;
use ElasticsearchConfig;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $elasticsearchClient;

    /**
     * EventServiceProvider constructor.
     * @param ElasticsearchConfig $elasticsearchConfig
     */
    public function __construct()
    {
        $this->elasticsearchClient = new ElasticsearchConfig();
    }

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
    ];



    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Event::listen('board.updated', function ($board){
            $board = Board::where('id', $board['id'])->first();
            $params = [
                'index' => 'board',
                'type' => 'v1',
                'id' => $board['id'],
                'body' => $board
            ];
            $this->elasticsearchClient->getClient()->index($params);
        });

        //
    }
}
