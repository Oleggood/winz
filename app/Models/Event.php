<?php

namespace App\Models;

//use App\Http\Traits\ImageTrait;
//use App\Http\Traits\TravelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Spatie\MediaLibrary\HasMedia;
//use Spatie\MediaLibrary\InteractsWithMedia;
//use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\App;


//class Event extends Model implements HasMedia
class Event extends Model
{
//    use HasFactory, InteractsWithMedia, HasFactory, ImageTrait, TravelTrait;
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'features',
        'start',
        'timezone',
        'difficult',
        'transport_provided',
        'min_participant',
        'opt_participant',
        'max_participant',
        'teams',
        'min_team',
        'opt_team',
        'max_team',
        'passenger',
        'fixed_team',
        'equipment',
        'food',
        'escort',
        'lodging',
        'accommodations',
        'min_preparation',
        'transport_requirements',
        'equipment_requirements',
        'other_requirements',
        'payment',
        'currency',
        'payment_requirements',
        'transfer',
        'description',
    ];

    protected $dates = ['start', 'end'];

    protected $appends = [
        'href',
        'country_name',
        'start_formatted',
        'start_formatted_edit',
        'end_formatted',
        'targets',
        'travel',
        'transports',
        'length_count',
        'length_text',
        'length_unit',
        'image',
        'images',
        'before_start',
        'name_formatted',
    ];

    //images
//    public function registerMediaConversions(Media $media = null): void
//    {
//        $this->addMediaConversion('ava')
//            ->crop('crop-center', 160, 160);
//        $this->addMediaConversion('full')
//            ->width(1500)
//            ->height(1500)
//            ->keepOriginalImageFormat();
//    }

    //relations
    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function getTravelAttribute()
    {
        return Travel::visible()
            ->WithTransports()
            ->find($this->travel_id);
    }

    public function eventTransports()
    {
        return $this->hasMany(EventTransport::class);
    }

    public function eventTargets()
    {
        return $this->hasMany(EventTarget::class);
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function gatherings()
    {
        return $this->hasMany(Gathering::class);
    }

    public function reviews()
    {
        return $this->hasMany(UserRating::class)->where('enabled', 1);
    }

    //attributes
    public function getTargetsAttribute()
    {
        return EventTarget::where('event_id', $this->id)->pluck('target_id')->toArray();
    }

    public function getTransportsAttribute()
    {
        return EventTransport::where('event_id', $this->id)->pluck('transport_id')->toArray();
    }

//    public function getImagesAttribute()
//    {
//        $images = $this->getMedia('images')->all();
//        foreach ($images as &$image) {
//            $image->thumb1 = $image->getUrl('ava');
//        }
//        return $images;
//    }

//    public function getImageAttribute()
//    {
//        return $this->getImage($this, 'ava', 'images')
//            ? $this->getImage($this, 'ava', 'images')
//            : url('/images/no-image.jpg');
//    }

//    public function getImageFullAttribute()
//    {
//        return $this->getImage($this, 'full', 'images');
//    }

    public function getLengthCountAttribute()
    {
        if (!isset($this->start) || !isset($this->end)) return '';
        return $this->end->diffInDays($this->start) ?: $this->end->diffInHours($this->start);
    }

    public function getLengthUnitAttribute()
    {
        return isset($this->start) && isset($this->end) && $this->end->diffInDays($this->start) ? 2 : 1;
    }

    public function getBeforeStartAttribute()
    {
        $now = new \DateTimeImmutable();
        return isset($this->start) ? $this->start->diff($now) : [];
    }

    public function getLengthTextAttribute()
    {
        if (!isset($this->end) || !isset($this->length_count)) return '';
        return $this->end->diffInDays($this->start)
            ? Lang::choice('event.crt_tx8_2', $this->length_count)
            : Lang::choice('event.crt_tx8_1', $this->length_count);
    }

    public function getBreadcrumbsAttribute()
    {
        return [
            [
                'route' => 'home',
                'name' => __('main.home')
            ], [
                'route' => 'events.index',
                'name' => __('main.event_list')
            ], [
                'name' => $this->start_formatted,
            ]
        ];
    }

    public function getStartFormattedAttribute()
    {
        if (!isset($this->start)) return '';
        $tmz = $this->timezone ?: '+0:00';
        return $this->start->format('d.m.Y H:i') . ' (UTC ' . $tmz . ')';
    }

    public function getStartFormattedEditAttribute()
    {
        if (!isset($this->start)) return '';
        return $this->start->format('Y-m-d H:i');
    }

    public function getEndFormattedAttribute()
    {
        if (!isset($this->end)) return '';
        return $this->end->format('d.m.Y H:i');
    }

    public function getStartDateAttribute()
    {
        if (!isset($this->start)) return '';
        return $this->start->format('d.m.Y');
    }

    public function getCountryNameAttribute()
    {
        return $this->travel->country_name;
    }

    public function getHrefAttribute()
    {
        return $this->id ? route('events.show', ['event' => $this->id]) : '';
    }

    public function getNameFormattedAttribute()
    {
        return (mb_strlen($this->name) > 30)
            ? mb_substr($this->name, 0, 30) . '...'
            : $this->name;
    }

    //scopes
    public function scopeVisible($query)
    {
        return $query->where('events.draft', '=', 0);
    }

    public function scopeActive($query)
    {
        return $query->where('events.status', '=', 1);
    }

    public function scopeDraft($query)
    {
        return $query->where('events.draft', '=', 1);
    }

    public function scopePublic($query)
    {
        return $query->where('events.type', '<>', 3);
    }

    public function scopeComing($query)
    {
        return $query->where('start', '>', new \DateTimeImmutable());
    }

    public function scopePassed($query)
    {
        return $query->where('start', '<', new \DateTimeImmutable());
    }

    public function scopeWithTravels($query)
    {
        return $query->leftJoin('travels', 'events.travel_id', '=', 'travels.id')
            ->select(
                'events.*',
                'travels.name as travel_name',
                'travels.region as travel_region',
                'travels.distance as travel_distance',
                'travels.surface as travel_surface',
                'travels.escort as travel_escort',
                'travels.start_point as start_point',
                'travels.end_point as end_point',
                'travels.points as points',
            );
    }

    public function scopeWithTransports($query)
    {
        return $query->with(['eventTransports' => function ($q) {
            $q->leftjoin('transports', 'transports.id', '=', 'event_transports.transport_id')
                ->leftjoin('transport_texts', 'transport_texts.transport_id', '=', 'event_transports.transport_id')
                ->where('transport_texts.language', App::getLocale());
        }]);
    }

    public function scopeWithTargets($query)
    {
        return $query->with(['eventTargets' => function ($q) {
            $q->leftjoin('targets', 'targets.id', '=', 'event_targets.target_id')
                ->leftjoin('target_texts', 'target_texts.target_id', '=', 'event_targets.target_id')
                ->where('target_texts.language', App::getLocale());;
        }]);
    }

    public function scopeWithRatings($query)
    {
        return $query->leftJoin('user_ratings', 'user_ratings.event_id', '=', 'events.id')
            ->where('status', 1)
            ->select('events.*',
                'user_ratings.review',
                'user_ratings.rating_event',
                'user_ratings.rating_travel',
                'user_ratings.rating_user');
    }
}
