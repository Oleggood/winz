<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'telegram_enable', 'telegram', 'email_enable', 'travel_enable', 'event_enable', 'help_enable', 'message_enable'];
}
