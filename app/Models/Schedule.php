<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'scheduled_time',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
