<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NewTemplate;


class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'template_id',
        'name',
        'description',
        'email_subject',
        'email_body',
        'scheduled_at',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function template()
    {
        return $this->belongsTo(NewTemplate::class);
    }

    public function emailStatuses()
    {
        return $this->hasMany(EmailStatus::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function recipients()
    {
        return $this->hasMany(Recipient::class);
    }
}
