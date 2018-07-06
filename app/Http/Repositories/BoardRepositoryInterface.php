<?php
/**
 * Created by PhpStorm.
 * User: rok
 * Date: 2018. 6. 17.
 * Time: PM 6:32
 */

namespace App\Repositories;

use App\Board;
use App\Dto\Result;

interface BoardRepositoryInterface
{
    public function update(Board $board) : Result;
}
