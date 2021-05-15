<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];
    use HasFactory;

    public function workers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Worker::class,'category_id','id');
    }

    public function subCategories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SubCategory::class,'category_id','id');
    }
    public function locales(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CategoryLocalesModel::class,'category_id','id');
    }
    public function vacations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Vacation::class,'category_id','id');
    }
}
