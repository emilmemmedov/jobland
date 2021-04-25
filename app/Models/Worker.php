<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;
    protected $table = "workers";
    protected $guarded = [];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'worker_id','id');
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class,'id','category_id');
    }

    public function subCategories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Sub_Category::class,'worker_sub_category','worker_id','sub_category_id');
    }

    public function vipVacations(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Vacation::class,'vip_vacations','worker_id','vacation_id');
    }

    public function interviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Interview::class,'worker_id','id')
            ->where('worker_delete','=','0');
    }

    public function ratings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Rating::class,'worker_id','id')
            ->where('worker_id', auth()->user()->worker()->id);
    }

    public function applied_vacation(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(VacationApply::class,'worker_id','id')
            ->where('worker_delete','=','0');
    }
}
