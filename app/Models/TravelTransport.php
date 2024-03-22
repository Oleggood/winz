<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelTransport extends Model
{
    use HasFactory;

    protected $fillable = ['travel_id', 'transport_id'];
}
