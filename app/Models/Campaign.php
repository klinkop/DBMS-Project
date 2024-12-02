<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use jdavidbakr\MailTracker\Model\SentEmail;
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
        'status',
        'sender_email',
        'sender_name',
        'email_body_json',
        'email_body_html',
    ];

    // protected $appends = [
    //     'open_rate',
    //     'click_rate'
    // ];

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

    public function sentEmails()
    {
        return $this->hasMany(SentEmail::class);
    }

    // public function getOpenRateAttribute()
    // {
    //     $totalEmails
    // }
}
