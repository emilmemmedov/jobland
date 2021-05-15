<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoryLocalesModel extends Model
{
    protected $table = "sub_category_locales";
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];
    use HasFactory;
}
