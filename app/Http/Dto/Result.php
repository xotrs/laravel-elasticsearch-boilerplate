<?php
/**
 * Created by PhpStorm.
 * User: rok
 * Date: 2018. 7. 6.
 * Time: PM 11:33
 */

namespace App\Dto;

class Result {
    private $result;

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result): void
    {
        $this->result = $result;
    }


}