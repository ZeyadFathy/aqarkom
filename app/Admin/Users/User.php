<?php

namespace App\admin\Users;

use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Admin\Advertisements\Advertisement;


class User extends Authenticatable
{
    use SoftDeletes;
    use HasApiTokens;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];
    protected $hidden = ['deleted_at'];
    protected $table = 'users';
    protected $appends = ['ads_count'];

    public function ads()
    {
        return $this->HasMany(Advertisement::class, 'user_id');
    }

    public function getAdsCountAttribute()
    {
        return $this->ads()->count();
    }

    public function getAvatarAttribute($avatar)
    {
        if (!empty($avatar)) {
            return request()->getSchemeAndHttpHost() . '/uploads/' . $avatar;
        }
    }
}
