<?php

namespace App\Admin\Advertisements;

use App\Admin\Advertisements\AdsData;
use App\Admin\Advertisements\AdsTextData;
use App\Admin\Categories\Category;
use App\Admin\Cities\City;
use App\Admin\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\ApiHelper;
use Carbon\Carbon;

class Advertisement extends Model
{
    //use SoftDeletes;

    protected $hidden = ['deleted_at'];
    protected $table = 'advertisements';
    protected $appends = ['last_update'];

    public function addata()
    {
        return $this->HasMany(AdsData::class, 'advertisement_id');
    }

    public function adtextdata()
    {
        return $this->HasMany(AdsTextData::class, 'advertisement_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function setImagesAttribute($images)
    {
        if (is_array($images)) {
            $this->attributes['images'] = json_encode($images);
        }
    }

    public function getImagesAttribute($images)
    {
        if (request()->route()->getPrefix() == 'api') {
            $images = json_decode($images, true);
            return $images ? ApiHelper::concatImages($images) : [];
        } else {
            $image = json_decode($images, true);
            if (empty($image) || count($image) <= 0) {
                return array('logo-background.jpg');
            }
            return $image;
        }

    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class, 'advertisement_id');
    }

    public function fav_count()
    {
        return $this->favourites()->count('id');
    }

    public function GetLastupdateAttribute()
    {
        $carbondate = Carbon::parse($this->updated_at);
        $past = $carbondate->diffForHumans();
        return $past;
    }

    public function ad_views()
    {
        return $this->hasOne(AdView::class, 'ad_id');
    }

    public function getPriceAttribute($price): ?string
    {
        if (request()->route()->getPrefix() == 'api' && request()->route()->getName() == 'ads.index') {
            $price = $this->number_formatter($price);
        }
        return $price;
    }

    public function number_formatter($n): string
    {
        $lang_ar = (request()->headers->get('lang') === 'ar');

        if ($n < 1000) {
            // Anything less than a million
            $number =  number_format($n);
            return ($lang_ar) ? $this->filter_num_ar($number) : $number;
        }
        if ($n < 1000000) {
            // Anything less than a million
            $number =  sprintf('%s %s', floatval(number_format($n / 1000,1) ), ($lang_ar ? 'الف' : 'K'));
            return ($lang_ar) ? $this->filter_num_ar($number) : $number;
        }
        if ($n < 1000000000) {
            // Anything less than a billion
            $number =  sprintf('%s %s', floatval(number_format($n / 1000000,1)), ($lang_ar ? 'مليون' : 'M'));
            return ($lang_ar) ? $this->filter_num_ar($number) : $number;
        }
        if ($n > 1000000000) {
            // At least a billion
            $number =  sprintf('%s %s', floatval(number_format($n / 100000000,1)), ($lang_ar ? 'بليون' : 'B'));
            return ($lang_ar) ? $this->filter_num_ar($number) : $number;
        }
    }

    public static function filter_num_ar($num)
    {
        $eArr = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '.');
        $aArr = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩', '٫');
        return str_ireplace($eArr, $aArr, $num);
    }
}
