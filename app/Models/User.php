<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
//use App\Http\Traits\ImageTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
//use Spatie\MediaLibrary\HasMedia;
//use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

//class User extends Authenticatable implements HasMedia




class User extends Authenticatable
{
//    use HasFactory, Notifiable, InteractsWithMedia, ImageTrait;
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',


        'phone',
        'region',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $appends = [
        'showname',
        'entity',
        'natural',
        'images',
        'href',
        'is_online',
        'was_online',
    ];

    protected $dates = [
        'online'
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

//    public function registerMediaConversions(Media $media = null): void
//    {
//        $this->addMediaConversion('ava')
//            ->crop('crop-center', 150, 150);
//        $this->addMediaConversion('ava_top')
//            ->crop('crop-center', 50, 50);
//        $this->addMediaConversion('full')
//            ->width(1500)
//            ->height(1500)
//            ->keepOriginalImageFormat();
//    }

    public function natural()
    {
        return $this->hasOne(UserNatural::class);
    }

    public function entity()
    {
        return $this->hasOne(UserEntity::class);
    }

    public function userNotifications()
    {
        return $this->hasOne(UserNotification::class);
    }

    public function getEntityAttribute()
    {
        return UserEntity::where('user_id', $this->id)->first();
    }

    public function getNaturalAttribute()
    {
        return UserNatural::where('user_id', $this->id)->first();
    }

    public function getShownameAttribute()
    {
        if ($this->id == config('app.admin_id'))
            return App::getLocale() == 'ru' ? 'Служба поддержки' : 'Support';
        $user_entity = UserEntity::where('user_id', $this->id)->first();
        if ($user_entity && $user_entity->name)
            return $user_entity->name;

        $user_natural = UserNatural::where('user_id', $this->id)->first();
        if ($user_natural && $user_natural->nickname)
            return $user_natural->nickname;
        if ($user_natural && $user_natural->name)
            return $user_natural->name;
        return 'user-' . $this->id;
    }

    public function getImagesAttribute()
    {
        $images = $this->getMedia('images')->all();
        foreach ($images as &$image) {
            $image->thumb1 = $image->getUrl('ava');
        }
        return $images;
    }

    public function getParticipateAttribute()
    {
        return Participant::where([
            ['user_id', $this->id],
            ['confirmed', 3]
        ])
            ->pluck('event_id')
            ->toArray();
    }

    public function getRatingAttribute()
    {
        $query = UserRating::where('user_id', $this->id);
        $sum = $query->sum('rating_user');
        if (!$sum) return 0;
        return number_format($sum / $query->count(), 1);
    }

    public function getAvaTopAttribute()
    {
        return $this->getImage($this, 'ava_top', 'images')
            ? $this->getImage($this, 'ava_top', 'images')
            : url('/images/no-avatar_50.webp');
    }

    public function getAvaFullAttribute()
    {
        return $this->getImage($this, 'full', 'images');
    }

    public function getAvaAttribute()
    {
        return $this->getImage($this, 'ava', 'images')
            ? $this->getImage($this, 'ava', 'images')
            : url('/images/no-avatar_150.webp');
    }

    public function getIsOnlineAttribute()
    {
        return $this->online > Carbon::parse('-5min');
    }

    public function getWasOnlineAttribute()
    {
        return $this->online->format('d.m.Y H:i');
    }

    public function getHrefAttribute()
    {
        return route('users.show', ['user' => $this->id]);
    }

    public function getUnreadMessagesAttribute()
    {
        return Message::where([
            ['target_type', 2],
            ['target_id', $this->id],
            ['read', 0],
        ])->count();
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = str_replace(['(', ')', '-', ' '], '', $value);
    }


}
