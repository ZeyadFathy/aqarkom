<?php
// Copyright
namespace App\Admin\Companies;

use App\Admin\Categories\Category;
use App\Admin\Cities\City;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'title_ar', 'title_en', 'description_ar', 'description_en', 'category_id', 'city_id', 'contact_number',
        'email', 'facebook', 'instagram', 'twitter', 'website', 'days', 'days_en', 'image', 'lat', 'long', 'csr'
    ];

    protected $hidden = ['deleted_at'];

    protected $table = 'companies';

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function company_category()
    {
        return $this->belongsTo(CompanyCategory::class, 'category_id');
    }

    public function portfolio()
    {
        return $this->hasMany(CompanyPortfolio::class, 'company_id');
    }

    public function getImageAttribute($avatar)
    {
        if (!empty($avatar)) {
            return 'https://aqarito.com/uploads/' . $avatar;
        }
    }

    public function company_review()
    {
        return $this->hasMany(CompanyReview::class, 'company_id')->where('status', 1)->limit('4');
    }

    public function company_view()
    {
        return $this->hasMany(CompanyView::class, 'company_id');
    }

    public function getDaysAttribute($days)
    {
        if (request()->route()->getPrefix() == 'api') {
            if (!is_null($days)){
                return json_decode($days);
            }else{
                return null;
            }
        }
        return $days;
    }

    public function getDaysEnAttribute($days)
    {
        if (request()->route()->getPrefix() == 'api') {
            if (!is_null($days)){
                return json_decode($days);
            }else{
                return null;
            }
        }
        return $days;
    }
}
