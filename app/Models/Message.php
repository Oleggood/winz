<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    /** target_type - получатель уведомления
     *  1- группа события
     *  2- пользователь
     */
    use HasFactory;

    protected $fillable = [
        'author_id',
        'target_id',
        'target_type',
        'text',
        'read'
    ];

    protected $appends = [
        'created_formatted',
        'is_my'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function getCreatedFormattedAttribute()
    {
        return $this->created_at->format('d.m.Y H:i');
    }

    public function getIsMyAttribute()
    {
        return $this->author_id == Auth::user()->id;
    }
}
