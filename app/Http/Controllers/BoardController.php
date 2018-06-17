<?php

namespace App\Http\Controllers;

use App\Board;
use App\Repositories\BoardRepository;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    protected $model;

    /**
     * BoardController constructor.
     */
    public function __construct(Board $board)
    {
        $this->model = new BoardRepository($board);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->model->create($request->only($this->model->getModel()->fillable)); // 데이터베이스 & 엘라스틱서치 삽입
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Board $board)
    {
        $this->model->update($request->only($this->model->getModel()->fillable), $board['id']); // 데이터베이스 & 엘라스틱서치 업데이트
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board)
    {
        $boardId = $board['id'];
        $board = Board::where('id', '=', $boardId)->get()[0];
        $result = $board->delete();
        print($result);
    }
}
