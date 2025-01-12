<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventTarget extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'target_id'];
}
