<?php
/**
 * Created by PhpStorm.
 * User: rok
 * Date: 2018. 6. 17.
 * Time: PM 6:32
 */

namespace App\Repositories;

interface BoardRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function update(array $data, $id);
    public function destroy($id);
    public function show($id);

}
