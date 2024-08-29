<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactList extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'sub_folder_id', 'name', 'status', 'company', 'pic', 'email', 'contact1', 'contact2', 'industry', 'city_id', 'state_id'
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subFolder(): BelongsTo
    {
        return $this->belongsTo(SubFolder::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
