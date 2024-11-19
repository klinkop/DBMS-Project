<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'recipient_email',
        'status',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
