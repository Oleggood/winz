<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageText extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'meta_description',
        'meta_title',
    ];
}
