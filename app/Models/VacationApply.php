<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacationApply extends Model
{
    protected $table = "vacation_apply";
    protected $guarded = [];
    protected $hidden = ['worker_delete','company_delete'];
    use HasFactory;
}
