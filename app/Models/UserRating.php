<?php

namespace App\Models;

use App\Http\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UserRating extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, ImageTrait;

    protected $fillable = [
        'rating_event',
        'rating_travel',
        'rating_user',
        'review',
        'enabled',
        'user_id',
        'author_id',
        'travel_id',
        'event_id'
    ];

    //images
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->crop('crop-center', 150, 150);
        $this->addMediaConversion('thumb2')
            ->crop('crop-center', 50, 50);
        $this->addMediaConversion('full')
            ->width(1500)
            ->height(1500)
            ->keepOriginalImageFormat();
    }

    //relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    //attributes
    public function getImagesAttribute()
    {
        $images = $this->getMedia('images')->all();
        $a = 5;
        foreach ($images as &$image) {
            $image->thumb1  = $image->getUrl('thumb');
        }
        return $images;
    }

    //scopes
    public function scopeVisible($query)
    {
        return $query->where('travels.draft', '=', 0);
    }

    public function scopeWithEvents($query)
    {
        return $query->leftJoin('events', 'events.id', '=', 'user_ratings.event_id')
            ->select('events.start', 'user_ratings.*');
    }
}
