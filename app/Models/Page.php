<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'published',
        'main_menu',
        'sort_order',
        'bottom',
    ];

    protected $casts = [
        'main_menu'
    ];

    public function getNameAttribute()
    {
        $page_text = PageText::where([
            ['page_id', $this->id],
            ['language', App::getLocale()],
        ])->first();
        return $this->texts->name ?? '';
    }

    public function getTextsAttribute()
    {
        return PageText::where([
            ['page_id', $this->id],
            ['language', App::getLocale()],
        ])->first();
    }
}
