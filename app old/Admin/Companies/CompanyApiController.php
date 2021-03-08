<?php

namespace App\Admin\Companies;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyApiController extends Controller
{
    public $helper;

    public function __construct()
    {
        $this->helper = new ApiHelper();
    }

    public function index(Request $request)
    {
        $title = 'title_ar as title';
        $description = 'description_ar as description';
        $title_city = 'title';

        if (request()->headers->get('lang') === 'en') {
            $title = 'title_en  as title';
            $description = 'description_en  as description';
            $title_city = 'title_en  as title';
        }


        $companies = Company::where(function ($query) use ($request) {
            if ($request->has('category_id')) {
                $query->where('category_id', $request->get('category_id'));
            }
            if ($request->has('city_id')) {
                $query->where('city_id', $request->get('city_id'));
            }
            if ($request->has('title')) {
                if (request()->headers->get('lang') === 'en') {
                    $query->where('title_en', 'like', '%' . $request->get('title') . '%');
                } else {
                    $query->where('title_ar', 'like', '%' . $request->get('title') . '%');
                }
            }
        })
            ->where('status', 1)
            ->orderby('featured', 'DESC')
            ->with(['company_category:id,' . $title, 'city:id,' . $title_city])
            ->select(['id', 'image','email','lat','long','contact_number', $title, $description, 'featured', 'city_id', 'category_id'])
            ->paginate(20);

        return response()->json([
            'data' => $companies,
            'moreData' => $companies->hasMorePages(),
            'status' => 1
        ]);
    }


    public function show($id)
    {
        $title = 'title_ar as title';
        $description = 'description_ar as description';
        $title_city = 'title';
        $days = 'days';

        if (request()->headers->get('lang') === 'en') {
            $title = 'title_en  as title';
            $description = 'description_en as description';
            $title_city = 'title_en  as title';
            $days = 'days_en as days';
        }


        $company = Company::where('id', $id)
            ->where('status', 1)
            ->with(['company_category:id,' . $title , 'city:id,' . $title_city , 'portfolio:id,company_id,images as image,' . $title])
            ->select(['id', $title, $description, 'city_id', 'category_id', 'contact_number', 'email', 'facebook', 'instagram', 'twitter', 'website', $days, 'image', 'lat', 'long', 'csr', 'featured'])
            ->withCount(['company_view'])
            ->first();
        if (isset($company)) {
            if (auth()->guard('api')->check()) {
                CompanyView::firstOrCreate([
                    'company_id' => $id,
                    'user_id' => auth()->guard('api')->user()->id
                ]);
            } else {
                CompanyView::create([
                    'company_id' => $id,
                ]);
            }
        }
        $company = collect($company);
        if (is_null($company->get('facebook'))) {
            $company->forget('facebook');
        }
        if (is_null($company->get('instagram'))) {
            $company->forget('instagram');
        }
        if (is_null($company->get('twitter'))) {
            $company->forget('twitter');
        }
        if (is_null($company->get('website'))) {
            $company->forget('website');
        }

        return $this->helper->output($company);
    }
}
