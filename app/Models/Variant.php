<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;
    protected $table = "question_variants";
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];
}
