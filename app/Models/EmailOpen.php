<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailOpen extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'opened_at',
        'ip_address',
        'user_agent',
    ];

    /**
     * Relationship with the Campaign model.
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}

