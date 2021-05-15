<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerSubCategory extends Model
{
    use HasFactory;
    protected $table = "worker_sub_category";
    protected $guarded = [];

    public function user(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class,'worker_id','id');
    }
}
