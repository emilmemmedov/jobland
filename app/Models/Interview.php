<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $table = "interviews";
    protected $guarded = [];

    public const CREATED = 1;
    public const ACCEPTED = 2;
    public const REJECTED = 3;
    public const CANCELED = 4;
    public const ACCEPT_WORKER = 5;
    public const REJECT_WORKER = 6;

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
