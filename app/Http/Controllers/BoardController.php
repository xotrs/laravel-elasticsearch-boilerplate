<?php

namespace App\Http\Controllers;

use App\Board;
use App\Http\Service\BoardService;
use ElasticsearchConfig;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    private $elasticsearchConfig;
    private $boardService;

    /**
     * BoardController constructor.
     * @param ElasticsearchConfig $elasticsearchConfig
     * @param BoardService $boardService
     */
    public function __construct(ElasticsearchConfig $elasticsearchConfig, BoardService $boardService)
    {
        $this->elasticsearchConfig = $elasticsearchConfig;
        $this->boardService = $boardService;
    }

    public function show(Board $board)
    {
        $params = [
            'index' => 'board',
            'type' => 'v1',
            'id' => $board['id']
        ];

        $result = $this->elasticsearchConfig->getClient()->get($params);
        $board = $result['_source'];

        return response()->json($board);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Board $board
     * @return string
     */
    public function store(Request $request, Board $board)
    {
        $board->setAttributes($request->all());

        $result = $this->boardService->store($board);

        return response()->json(['result' => $result]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Board $board
     * @return bool
     */
    public function update(Request $request, Board $board)
    {
        $result = $this->boardService->update($board->fillable($request->all()));

        return response()->json(['result' => $result]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board)
    {
        $result = $this->boardService->delete($board);

        return response()->json(['result' => $result]);
    }
}
