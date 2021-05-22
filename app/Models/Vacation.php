<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    protected $table = "vacations";
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }

    public function icon(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(File_Service::class,'id','icon');
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class,'id','category_id');
    }

    public function subCategories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(SubCategory::class,'vacation_sub_category','vacation_id','sub_category_id');

    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class,'vacation_id','id');
    }
    public function lastComment(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Comment::class,'vacation_id','id')->latest();
    }
    public function assignment(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Assignment::class,'id','assignment_id');
    }
}
