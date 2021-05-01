<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryLocalesModel extends Model
{
    protected $table = "categories";
    protected $guarded = [];
    use HasFactory;
}
