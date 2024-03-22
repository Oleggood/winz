<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNatural extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'lastname', 'nickname', 'gender', 'blog_link', 'video_link', 'guide', 'about', 'socials'];

    protected $dates = ['birthday'];

}
