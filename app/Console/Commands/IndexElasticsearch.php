<?php

namespace App\Console\Commands;

use App\Board;
use App\Repositories\BoardRepository;
use ElasticsearchConfig;
use Illuminate\Console\Command;

class IndexElasticsearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cherrypick:IndexElasticsearch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '엘라스틱서치 초기 색인 작업';
    private $elasticsearchConfig;
    private $boardRepository;

    /**
     * Create a new command instance.
     *
     * @param BoardRepository $boardRepository
     * @param ElasticsearchConfig $elasticsearchConfig
     */
    public function __construct(BoardRepository $boardRepository, ElasticsearchConfig $elasticsearchConfig)
    {
        $this->boardRepository = $boardRepository;
        $this->elasticsearchConfig = $elasticsearchConfig;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->indexElasticsearch();

        return;
    }

    public function indexElasticsearch()
    {
        $start = microtime(true);
        $this->output->writeln("start : ".$start);

        $boards = $this->boardRepository->all();

        $params = ['body' => []];

        foreach($boards as $index => $board){
            $params['body'][] = [
                'index' => [
                    '_index' => 'board',
                    '_type' => 'v1',
                    '_id' => $board->id
                ]
            ];

            array_push($params['body'], $board);

            if($index % 10 == 0){
                $responses = $this->elasticsearchConfig->getClient()->bulk($params);

                $params = ['body' => []];
                unset($responses);
            }
        }

        if (!empty($params['body'])) {
            $responses = $this->elasticsearchConfig->getClient()->bulk($params);
        }

        $end = microtime(true);
        $time = $end - $start;
        $this->output->writeln("end : ".$end);
        $this->output->writeln("running time : ".$time);

    }
}
