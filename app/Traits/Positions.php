<?php


namespace App\Traits;


use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

trait Positions
{
    public function getPositionId(Model $model){
        return $model::query()->max('position_id') + 1;
    }
    public function getPositionIdSpecialColumn(Model $model, Model $parentModel,$id){
        return $model::query()
                ->where($parentModel->getForeignKey(),'=', $id)
                ->max('position') + 1;
    }
}
