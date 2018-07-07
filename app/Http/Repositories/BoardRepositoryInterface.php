<?php
/**
 * Created by PhpStorm.
 * User: rok
 * Date: 2018. 6. 17.
 * Time: PM 6:32
 */

namespace App\Repositories;

use App\Board;

interface BoardRepositoryInterface
{
    public function update(Board $board) : bool;
    public function delete(Board $board) : bool;
    public function store(Board $board) : bool;
    public function all();
}
