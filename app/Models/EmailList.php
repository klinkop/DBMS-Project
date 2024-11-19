<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailList extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'list_name',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function emails()
    {
        return $this->hasMany(Email::class);
    }
}
