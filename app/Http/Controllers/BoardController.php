<?php

namespace App\Http\Controllers;

use App\Board;
use App\Http\Service\BoardService;
use ElasticsearchConfig;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    private $elasticsearchClient;
    private $boardService;

    /**
     * BoardController constructor.
     * @param ElasticsearchConfig $elasticsearchConfig
     * @param BoardService $boardService
     */
    public function __construct(ElasticsearchConfig $elasticsearchConfig, BoardService $boardService)
    {
        $this->elasticsearchClient = $elasticsearchConfig;
        $this->boardService = $boardService;
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

    /**
     * Store a newly created resource in storage.
     *
     * @return string
     */
    public function store()
    {

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

    }
}
