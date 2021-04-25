<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    protected $table = "interviews";
    protected $guarded = [];

    use HasFactory;

    public function worker(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Worker::class,'id','worker_id');
    }

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class,'id','company_id');
    }

    public function getRejectedOfferType(){
        return auth()->user()->reject_offer_by;
    }
}
