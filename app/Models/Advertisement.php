<?php

namespace App\Models;

use App\Helpers\FormatNumber;
use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Advertisement extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'type', 'property_type', 'title', 'slug', 'details', 'category_id', 'user_id', 'city_id' ,
        'price', 'area', 'ad_long', 'ad_lat', 'status',
    ];

    protected $hidden = ['deleted_at'];

    public function getImagesAttribute($images)
    {
        $images = json_decode($images, true);
        return $images ? ImageHelper::concatImages($images) : [];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

//    public function getImagesAttribute($images)
//    {
//        $images = json_decode($images, true);
//        return $images ? ImageHelper::concatImages($images) : [url('/uploads/images/default.jpg')];
//    }

    public function adtextdata()
    {
        return $this->HasMany(AdsTextData::class, 'advertisement_id');
    }

    public function addata()
    {
        return $this->HasMany(AdsData::class, 'advertisement_id');
    }

    public function getPriceAttribute($price): ? string
    {
        return FormatNumber::make($price);
    }

    /**
     * Scope functions
     *
     * @param [type] $query
     * @param [type] $attr
     * @return void
     */
    public function scopeFilterById($query, $attr)
    {
        if( isset($attr['id']) ) {
            return $query->where('id', $attr['id']);
        }
    }

    public function scopeFilterByLocation($query, $attr)
    {
        if( isset($attr['location']) ) {
            return $query->where('location', 'like', '%'.$attr['location']);
        }
    }

    public function scopeFilterByCategory($query, $attr)
    {
        if( isset($attr['category_id']) and is_array($attr['category_id']) and count($attr['category_id']) > 0 ) {
            return $query->whereIn('category_id', $attr['category_id']);
        }
    }

    public function scopeFilterByType($query, $attr)
    {
        if( isset($attr['type']) and is_array($attr['type']) and count($attr['type']) > 0 ) {
            return $query->whereIn('type', $attr['type']);
        }

    }

    public function scopeFilterByPrice($query, $attr)
    {
        if( isset($attr['price_start']) and isset($attr['price_end']) ) {
            return $query->whereBetween('price', [
                $attr['price_start'],
                $attr['price_end']
            ]);
        } elseif(isset($attr['price_start'])) {
            return $query->where('price', '>=',  $attr['price_start']);
        } elseif(isset($attr['price_end'])) {
            return $query->where('price', '<=',  $attr['price_end']);
        }
    }


    public function scopeFilterByCity($query, $attr)
    {
        if( isset($attr['city']) and is_array($attr['city']) ) {
            return $query->whereIn('city_id', $attr['city']);
        }
    }

    public function scopeFilterByLatAndLng($query, $attr)
    {
        if( isset($attr['lat']) and isset($attr['lng']) ) {
            return
                $query
                    ->whereRaw(
                        \DB::raw("( 6367 * acos( cos( radians(".$attr['lat'].") ) * cos( radians( ad_lat ) )  * cos( radians( ad_long ) - radians(".$attr['lng'].") ) + sin( radians(".$attr['lat'].") ) * sin( radians( ad_lat ) ) ) ) < 25")
                    );
        }
    }

    public function scopeFilterByFeatured($query, $attr)
    {
        if( isset($attr['featured']) and $attr['featured'] == true) {
            return $query->where('featured', 1);
        }
    }

    public function scopeFilterBySort($query, $attr)
    {
        if( isset($attr['sort']) ) {
            if( $attr['sort'] == 'latest' ) {
                return $query->orderBy('id', 'DESC');
            } elseif($attr['sort'] == 'low_price') {
                return $query->orderBy('price', 'ASC');
            } elseif($attr['sort'] == 'high_price') {
                return $query->orderBy('price', 'DESC');
            } elseif($attr['sort'] == 'low_space') {
                return $query->orderBy('area', 'ASC');
            } elseif($attr['sort'] == 'high_space') {
                return $query->orderBy('area', 'DESC');
            }
        } else {
            return $query->orderBy('id', 'DESC');
        }
    }



}
