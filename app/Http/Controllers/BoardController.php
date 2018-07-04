<?php

namespace App\Http\Controllers;

use App\Board;
use App\Repositories\BoardRepository;
use ElasticsearchConfig;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    protected $model;
    protected $elasticsearchClient;

    /**
     * BoardController constructor.
     * @param Board $board
     * @param ElasticsearchConfig $elasticsearchConfig
     */
    public function __construct(Board $board, ElasticsearchConfig $elasticsearchConfig)
    {
        $this->model = new BoardRepository($board);
        $this->elasticsearchClient = $elasticsearchConfig;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

//    public function sync(Request $request)
//    {
//        foreach ($this->model->all() as $board){
//            $params = [
//                'index' => 'board',
//                'type' => 'v1',
//                'id' => $board['id'],
//                'body' => $board
//            ];
//
//            $this->elasticsearchClient->getClient()->index($params);
//        };
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @return string
     */
    public function store()
    {

    }

    public function syncDatabaseAndElasticsearch(){
        //In Elasticsearch Not in Database
        $params = [
            'index' => 'board',
            'type' => 'v1',
            'body' => ['sort' => ['_id' => 'asc']]
        ];

        $result = $this->elasticsearchClient->getClient()->search($params);

        if($result['hits']['total'] > 0){
            $boards = $result['hits']['hits'];

            foreach($boards as $board){
                $boardDatabaseResult = Board::query()->where('id', $board['_id'])->get();

                if($boardDatabaseResult->isEmpty()){
                    $this->elasticsearchClient->getClient()->delete(['index' => 'board', 'type' => 'v1', 'id' => $board['_id']]);
                }
            }
        }
        //In Database Not in Elasticsearch
        foreach($this->model->all() as $board){
            if(!($this->elasticsearchClient->getClient()->exists(['index' => 'board', 'type' => 'v1', 'id' => $board['id']]))){
                $params = [
                    'index' => 'board',
                    'type' => 'v1',
                    'id' => $board['id'],
                    'body' => $board
                ];

                $this->elasticsearchClient->getClient()->index($params);
            }
        }
        return 'success';
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function show(Board $board)
    {
        $boardId = $board['id'];
        $board = Board::search()->match("id", $boardId)->get();
        print($board->hits()[0]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function edit(Board $board)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Board  $board
     * @return string
     */
    public function update(Request $request, Board $board)
    {
//        Board::where('id', $board['id'])->update($request->only($this->model->getModel()->fillable));
        Board::where('id', $board['id'])->update(['title' => 'selling']);

        $boardResult = new Board();
        $boardResult->setAttribute('id', $board['id']);
        event('board.updated', [$boardResult]);



        return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board)
    {

    }
}
