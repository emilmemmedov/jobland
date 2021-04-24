<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";
    protected $guarded = [];
    use HasFactory;

    public function workers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Worker::class,'category_id','id');
    }

    public function subCategories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Sub_Category::class,'category_id','id');
    }

    public function vacations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Vacation::class,'category_id','id');
    }
}
