<?php
/**
 * Created by PhpStorm.
 * User: rok
 * Date: 2018. 6. 13.
 * Time: PM 3:59
 */

namespace App\Http\Controllers;

use App\Board;
use Illuminate\Http\Request;

class SearchController
{
    public function index(Request $request){
        $keyword = $request['keyword'];
        $boards = Board::search()->queryString($keyword, ["default_field" => "title"])->get();
        print($boards->hits());
    }
}