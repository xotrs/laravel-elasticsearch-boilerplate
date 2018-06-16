<?php
/**
 * Created by PhpStorm.
 * User: rok
 * Date: 2018. 6. 13.
 * Time: PM 10:23
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Sleimanx2\Plastic\Searchable;

class Board extends Model
{
    use Searchable;

    public $documentIndex = 'board';
    public $documentType = 'v1';

    protected $fillable = [
        'id', 'title', 'content', 'created_at', 'updated_at'
    ];

    public $searchable = [
        'id', 'title', 'content', 'created_at', 'updated_at'
    ];
}