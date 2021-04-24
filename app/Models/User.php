<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    public $USER_TYPE_BUSINESSMAN = 1;
    public $USER_TYPE_WORKER = 2;

    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function worker(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Worker::class,'id','worker_id');
    }

    public function company(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Company::class,'id','company_id');
    }

    public function avatar(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(File_Service::class,'id','avatar');
    }

    public function getUserType(){
        return auth()->user()->type;
    }
}
