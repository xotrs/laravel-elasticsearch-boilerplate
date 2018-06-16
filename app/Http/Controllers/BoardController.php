<?php
/**
 * Created by PhpStorm.
 * User: rok
 * Date: 2018. 6. 16.
 * Time: PM 8:05
 */

namespace App\Http\Controllers;

use App\Board;
use Illuminate\Http\Request;
use Sleimanx2\Plastic\Facades\Plastic;

class BoardController
{
    //bulk를 이용한 board document 색인 기능
    public function createIndex(Request $request){
        $boards = Board::all();
        $result = Plastic::persist()->bulkSave($boards);

        return $result;
    }

    //match query를 이용한 board detail 조회 기능
    public function show(Request $request){
        $boardId = $request['id'];
        $board = Board::search()->match("id", $boardId)->get();
        print($board->hits()[0]);
    }

    //board id를 이용한 단일 document 삭제 기능
    public function destroy(Request $request){
        $boardId = $request['id'];
        $board = Board::where('id', '=', $boardId)->get()[0];
        $result = $board->delete();
        print($result);
    }

    //board id를 이용한 단일 document 수정 기능
    public function update(Request $request, Board $board){
        print($board);
    }
}