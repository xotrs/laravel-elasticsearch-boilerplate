<?php
/**
 * Created by PhpStorm.
 * User: rok
 * Date: 2018. 6. 17.
 * Time: PM 6:32
 */

namespace App\Repositories;

use App\Board;

class BoardRepository implements BoardRepositoryInterface
{
    private $board;

    public function __construct(Board $board)
    {
        $this->board = $board;
    }

    /**
     * @param Board $board
     * @return bool
     */
    public function update(Board $board) : bool
    {
        $board->setAttributes($board->getFillable());
        return $board->save();
    }
}
