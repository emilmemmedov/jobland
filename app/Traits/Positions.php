<?php


namespace App\Traits;


use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

trait Positions
{
    public function getPositionId(Model $model){
        return Category::query()->max('position_id') + 1;
    }
}
