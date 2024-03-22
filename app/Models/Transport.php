<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use HasFactory;

    protected $fillable = ['sort_order', 'step_min', 'step_max', 'svg', 'surface', 'category_id', 'passengers'];
}
