<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventTransport extends Model
{
    use HasFactory;

     protected $fillable = ['event_id', 'transport_id'];
}
