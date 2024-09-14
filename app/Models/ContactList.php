<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactList extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'sub_folder_id', 'name', 'status_id', 'type_id', 'company', 'product', 'pic', 'email', 'contact1', 'contact2', 'industry', 'address', 'city_id', 'state_id', 'remarks'
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subFolder(): BelongsTo
    {
        return $this->belongsTo(SubFolder::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
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
