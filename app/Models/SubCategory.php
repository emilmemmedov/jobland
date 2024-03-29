<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = "sub_categories";
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];
    use HasFactory;

    public function workers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Worker::class,'worker_sub_category','sub_category_id','worker_id');
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class,'id','category_id');
    }

    public function locales(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SubCategoryLocalesModel::class,'sub_category_id','id');
    }

    public function vacations(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Vacation::class,'vacation_sub_category','vacation_id','sub_category_id');
    }
}
