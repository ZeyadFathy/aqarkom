<?php
// Copyright
namespace App\Admin\Companies;

use App\Admin\Categories\Category;
use App\Admin\Cities\City;
use App\admin\Users\User;
use App\Helpers\ApiHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyReview extends Model
{
    //
    use SoftDeletes;

    protected $hidden = ['deleted_at'];

    protected $table = 'company_review';

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
