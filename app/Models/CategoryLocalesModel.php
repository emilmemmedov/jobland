<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryLocalesModel extends Model
{
    protected $table = "category_locales";
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];
    use HasFactory;
}
