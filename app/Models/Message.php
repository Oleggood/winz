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
//    use HasFactory;

    protected $guarded = false;
    protected $table = 'messages';

//    protected $appends = [
//        'created_formatted',
//        'is_my'
//    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getTimeAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getIsOwnerAttribute()
    {
        return (int) $this->user_id === (int) Auth::user()->id;
    }
}
