<?php
// Copyright
namespace App\Admin\Companies;

use App\Admin\Categories\Category;
use App\Admin\Cities\City;
use App\Helpers\ApiHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyPortfolio extends Model
{
    //
    use SoftDeletes;

    protected $hidden = ['deleted_at'];

    protected $table = 'company_portfolio';

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
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
            if (request()->route()->getName() == 'companies.show'){
                return $images ? ApiHelper::concatImages($images)[0] : [];
            }
            return $images ? ApiHelper::concatImages($images) : [];
        } else {
            $image = json_decode($images, true);
            if (empty($image) || count($image) <= 0) {
                return array('logo-background.jpg');
            }
            return $image;
        }
    }

    public function getImageAttribute($images)
    {
        if (request()->route()->getPrefix() == 'api') {
            $images = json_decode($images, true);
            if (request()->route()->getName() == 'companies.show'){
                return $images ? ApiHelper::concatImages($images)[0] : [];
            }
            return $images ? ApiHelper::concatImages($images) : [];
        } else {
            $image = json_decode($images, true);
            if (empty($image) || count($image) <= 0) {
                return array('logo-background.jpg');
            }
            return $image;
        }
    }
}
