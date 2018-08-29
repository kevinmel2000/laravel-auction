<?php

namespace Soumen\Auction\Models;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $table = 'bids';

    protected $fillable = [
        'model_id',
        'model_type',
        'user_id',
        'bid_value',
    ];

    public function model()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
