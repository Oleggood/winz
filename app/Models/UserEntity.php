<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEntity extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'code', 'specialization', 'site_link', 'about'];
}
