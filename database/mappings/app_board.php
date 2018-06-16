<?php

use Sleimanx2\Plastic\Map\Blueprint;
use Sleimanx2\Plastic\Mappings\Mapping;

class AppBoard extends Mapping
{
    /**
     * Full name of the model that should be mapped
     *
     * @var string
     */
    protected $model = App\Board::class;

    /**
     * Run the mapping.
     *
     * @return void
     */
    public function map()
    {
        Map::create($this->getModelType(),function(Blueprint $map){
            $map->integer('id');
            $map->string('title', ['analyzer' => 'custom_index_analyzer', 'search_analyzer' => 'custom_search_analyzer']);
            $map->string('content', ['analyzer' => 'custom_index_analyzer', 'search_analyzer' => 'custom_search_analyzer']);
            $map->date("created_at", ["format" => "yyyy-MM-dd HH:mm:ss"]);
            $map->date("updated_at", ["format" => "yyyy-MM-dd HH:mm:ss"]);
        },$this->getModelIndex());
    }
}
