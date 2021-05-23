<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentResult extends Model
{
    use HasFactory;
    protected $table = 'assignment_results';

    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];

    public $ACTIVE = 1;
    public $CLOSE = 0;

}
