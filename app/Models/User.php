<?php

namespace App\Models;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject, HasMedia
{
    use Notifiable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getAvatarAttribute()
    {
        return $this->getFirstMediaUrl('avatar');
    }

    public function accountType()
    {
        return $this->belongsTo(AccountType::class);
    }

    public function offerTransaction()
    {
        return $this->hasMany(OfferTransaction::class);
    }

    public function bouquetTransaction()
    {
        return $this->hasMany(BouquetTransaction::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function companyReviews()
    {
        return $this->hasMany(CompanyReview::class);
    }

    public function bouquetTrack()
    {
        return $this->hasOne(BouquetTracking::class);
    }
}
