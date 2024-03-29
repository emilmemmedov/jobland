<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = "companies";
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'id','company_id');
    }

    public function icon(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(File_Service::class,'id','company_icon');
    }

    public function vacations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Vacation::class,'company_id','id');
    }

    public function interviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Interview::class,'company_id','id')
            ->where('company_delete','=','0');
    }

    public function workers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Working::class,'company_id','id');
    }

    public function locales(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CompanyLocale::class,'company_id','id');
    }
}
