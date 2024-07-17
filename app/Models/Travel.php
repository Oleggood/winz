<?php

namespace App\Models;

use App\Http\Traits\GeoTrait;
use App\Http\Traits\ImageTrait;
use App\Http\Traits\TravelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Travel extends Model
//    implements HasMedia
{
//    use HasFactory, InteractsWithMedia, GeoTrait, ImageTrait, TravelTrait;

    protected $table = 'travels';
    protected $guarded = false;

//    protected $fillable = [
//        'name',
//        'country',
//        'region',
//        'distance',
//        'surface',
//        'difficult',
//        'escort',
//        'availability',
//        'description1',
//        'description2',
//    ];
//
//    protected $appends = [
//        'country_name',
//        'image',
//        'images',
//        'short_description1',
//        'href',
//        'transports',
//        'start_parsed',
//        'end_parsed',
//        'points_parsed',
//        'availability_parsed'
//    ];

//    public function registerMediaConversions(Media $media = null): void
//    {
//        $this->addMediaConversion('full')
//            ->width(1500)
//            ->height(1500)
//            ->keepOriginalImageFormat();
//        $this->addMediaConversion('thumb1')
//            ->crop('crop-center', 160, 160);
//    }
//
//    //relations
//    public function user()
//    {
//        return $this->belongsTo(User::class, 'author_id');
//    }
//
//    public function events()
//    {
//        return $this->hasMany(Event::class);
//    }
//
//    public function travelTransports()
//    {
//        return $this->hasMany(TravelTransport::class);
//    }
//
//    //attributes
//    public function getImagesAttribute()
//    {
//        $images = $this->getMedia('images')->all();
//        foreach ($images as &$image) {
//            $image->thumb1 = $image->getUrl('thumb1');
//        }
//        return $images;
//    }
//
//    public function getImageAttribute()
//    {
//        return $this->getImage($this, 'thumb1', 'images')
//            ? $this->getImage($this, 'thumb1', 'images')
//            : url('/images/no-image.jpg');
//    }
//
//    public function getTransportsAttribute()
//    {
//        return TravelTransport::where('travel_id', $this->id)->pluck('transport_id')->toArray();
//    }
//
//    public function getCountryNameAttribute()
//    {
//        return $this->countryByCode($this->country);
//    }
//
//    public function getShortDescription1Attribute()
//    {
//        return (mb_strlen($this->description1) > 80)
//            ? mb_substr($this->description1, 0, 80) . '...'
//            : $this->description1;
//    }
//
//    public function getHrefAttribute()
//    {
//        return route('travels.show', ['travel' => $this->id]);
//    }
//
//    public function getBreadcrumbsAttribute()
//    {
//        return [
//            [
//                'route' => 'home',
//                'name' => __('main.home')
//            ], [
//                'route' => 'travels.index',
//                'name' => __('main.list')
//            ], [
//                'name' => $this->name,
//            ]
//        ];
//    }
//
//    public function getStartParsedAttribute()
//    {
//        return json_decode($this->start_point);
//    }
//
//    public function getEndParsedAttribute()
//    {
//        return json_decode($this->end_point);
//    }
//
//    public function getPointsParsedAttribute()
//    {
//        return json_decode($this->points);
//    }
//
//    public function getAvailabilityParsedAttribute()
//    {
//        return json_decode($this->availability);
//    }
//
//    public function getDistanceFormattedAttribute()
//    {
//        return number_format($this->distance, 1, '.', ' ');
//    }
//
//    public function getRatingAttribute()
//    {
//        $query = UserRating::where([
//            ['travel_id', $this->id],
//            ['enabled', 1]
//        ]);
//        $sum = $query->sum('rating_travel');
//        if (!$sum) return 0;
//        return number_format($sum / $query->count(), 1);
//    }
//
//    public function getEventsRatingAttribute()
//    {
//        $query = UserRating::where('travel_id', $this->id);
//        $sum = $query->sum('rating_event');
//        if (!$sum) return 0;
//        return number_format($sum / $query->count(), 1);
//    }
//
//    public function getReviewsAttribute()
//    {
//        return UserRating::where('travel_id', $this->id)
//            ->orderBy('created_at', 'asc')
//            ->get();
//    }
//
//    //scopes
//    public function scopeVisible($query)
//    {
//        return $query->where('travels.draft', '=', 0);
//    }
//
//    public function scopeDraft($query)
//    {
//        return $query->where('travels.draft', '=', 1);
//    }
//
//    public function scopeWithTransports($query)
//    {
//        return $query->with(['travelTransports' => function ($q) {
//            $q->leftjoin('transports', 'transports.id', '=', 'travel_transports.transport_id')
//                ->leftjoin('transport_texts', 'transport_texts.transport_id', '=', 'travel_transports.transport_id')
//                ->where('transport_texts.language', App::getLocale());
//        }]);
//    }
//
//    public function scopeActive($query)
//    {
//        return $query->where('travels.status', '=', 1);
//    }

}
