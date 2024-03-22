<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gathering extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'text',
        'done'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
