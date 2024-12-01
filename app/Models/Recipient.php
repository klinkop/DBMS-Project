<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    use HasFactory;

    protected $fillable = ['campaign_id', 'sub_folder_id'];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function subFolder()
    {
        return $this->belongsTo(SubFolder::class);
    }
}
