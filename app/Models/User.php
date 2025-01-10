<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Add relationship between User model to other models that require the User model:
     *
     * 1. Parent Folder
     * 2. Sub Folder
     * 3. Contact List
     */
    public function parentFolder(): HasMany
    {
        return $this->hasMany(ParentFolder::class);
    }

    public function subFolder(): HasMany
    {
        return $this->hasMany(SubFolder::class);
    }

    public function contactList(): HasMany
    {
        return $this->hasMany(ContactList::class);
    }
    public function groups()
    {
        return $this->hasMany(Group::class);
    }
    public function campaign(): HasMany
    {
        return $this->hasMany(Campaign::class);
    }
}

