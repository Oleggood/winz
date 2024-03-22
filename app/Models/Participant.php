<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'role',
        'description',
        'passengers',
        'user_id',
        'confirmed'
    ];

    protected $appends = [
        'created_formatted',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //attributes
    public function getCreatedFormattedAttribute()
    {
        return $this->created_at->format('d.m.Y');
    }

    public function scopeConfirmed($query)
    {
        return $query->whereIn('confirmed', [1, 3]);
    }
}
