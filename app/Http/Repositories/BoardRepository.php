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

class BoardRepository implements BoardRepositoryInterface
{
    private $board;
    private $result;

    // Constructor to bind model to repo
    public function __construct(Board $board, Result $result)
    {
        $this->board = $board;
        $this->result = $result;
    }

    /**
     * @param Board $board
     * @return Result
     */
    public function update(Board $board) : Result
    {
        $board->setAttributes($board->getFillable());
        $boardUpdateResult = $board->save();

        $this->result->setResult($boardUpdateResult);

        return $this->result->getResult();
    }
}
