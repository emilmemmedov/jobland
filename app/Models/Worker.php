<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Worker extends Model
{
    use HasFactory;
    protected $table = "workers";
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'worker_id','id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class,'id','category_id');
    }

    public function subCategories(): BelongsToMany
    {
        return $this->belongsToMany(Sub_Category::class,'worker_sub_category','worker_id','sub_category_id');
    }

    public function vipVacations(): BelongsToMany
    {
        return $this->belongsToMany(Vacation::class,'vip_vacations','worker_id','vacation_id');
    }

    public function interviews(): HasMany
    {
        return $this->hasMany(Interview::class,'worker_id','id')
            ->where('worker_delete','=','0');
    }

    public function applied_vacation(): HasMany
    {
        return $this->hasMany(VacationApply::class,'worker_id','id')
            ->where('worker_delete','=','0');
    }
    public function works(): HasMany
    {
        return $this->hasMany(Working::class,'worker_id','id');
    }
}
