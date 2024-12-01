<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Metric extends Model
{
    protected $fillable = [
        'campaign_id',
        'impressions',
        'clicks',
        'conversions',
        'open_rate',
        'click_rate',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
