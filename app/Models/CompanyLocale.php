<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyLocale extends Model
{
    public $table = "company_locales";
    public $guarded = ['created_at','updated_at'];
    use HasFactory;
}
