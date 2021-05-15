<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacationSubCategory extends Model
{
    use HasFactory;

    protected $table = "vacation_sub_category";
    protected $guarded = ['created_at', 'updated_at'];

}
