<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'abbreviation'];

    public function contactLists(): HasMany
    {
        return $this->hasMany(ContactList::class);
    }
}
