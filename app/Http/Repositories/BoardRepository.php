<?php
/**
 * Created by PhpStorm.
 * User: rok
 * Date: 2018. 6. 17.
 * Time: PM 6:32
 */

namespace App\Repositories;

use App\Board;
use Exception;

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
        try {
            $board->setAttributes($board->getFillable());
            return $board->save();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param Board $board
     * @return bool
     */
    public function delete(Board $board) : bool
    {
        try {
            return Board::destroy($board['id']);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param Board $board
     * @return bool
     */
    public function store(Board $board) : bool
    {
        try {
            return $board->save();
        } catch (Exception $e) {
            return false;
        }
    }

    public function all()
    {
        return $this->board->all();
    }
}
