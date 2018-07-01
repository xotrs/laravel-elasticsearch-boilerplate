<?php
/**
 * Created by PhpStorm.
 * User: rok
 * Date: 2018. 6. 13.
 * Time: PM 10:23
 */

namespace App;


use App\Http\Controllers\BoardController;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $fillable = [
        'id', 'title', 'content', 'created_at', 'updated_at'
    ];
    protected $boardController;

    protected static function boot()
    {
        parent::boot();

        static::updating(function($board) {
            $boardController = new BoardController($board);
            $boardController->updateDocument($board);
        });
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }
}