<?php
/**
 * Created by PhpStorm.
 * User: rok
 * Date: 2018. 7. 6.
 * Time: PM 10:17
 */

namespace App\Http\Service;

use App\Board;
use App\Repositories\BoardRepository;

class BoardService
{
    private $boardRepository;

    /**
     * BoardService constructor.
     * @param BoardRepository $boardRepository
     */
    public function __construct(BoardRepository $boardRepository)
    {
        $this->boardRepository = $boardRepository;
    }

    public function update(Board $board) : bool
    {
        return $this->boardRepository->update($board);
    }

    public function delete(Board $board) : bool
    {
        return $this->boardRepository->delete($board);
    }

    public function store(Board $board) : bool
    {
        return $this->boardRepository->store($board);
    }
}

