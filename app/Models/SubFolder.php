<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubFolder extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parentFolder(): BelongsTo
    {
        return $this->belongsTo(ParentFolder::class);
    }

    public function contactLists(): HasMany
    {
        return $this->hasMany(ContactList::class);
    }
}
