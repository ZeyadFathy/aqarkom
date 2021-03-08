<?php

namespace App\Admin\Companies;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;

class CompanyCategoryApiController extends Controller
{
    public $helper;

    public function __construct()
    {
        $this->helper = new ApiHelper();
    }


    public function index()
    {
        $title = 'title_ar as title';

        if (request()->headers->get('lang') === 'en') {
            $title = 'title_en  as title';
        }

        $obj = CompanyCategory::select(['id', $title])->get()->toArray();
        return $this->helper->output($obj);
    }


    public function show($id)
    {
        //
        $ads = Company::where(function ($query) use ($id) {
            if ((int)$id !== -1) {
                $query->where('category_id', $id);
            }
            $query->where('status', 1);
            $query->orderby('featured', 'DESC');
        })
            ->with(['company_category:id,title_ar,title_en', 'city:id,title'])
            ->select(['id', 'title_ar', 'title_en', 'image', 'description', 'featured', 'city_id', 'category_id'])
            ->latest()
            ->paginate(20);

        return response()->json([
            'data' => $ads->getCollection(),
            'moreData' => $ads->hasMorePages(),
            'status' => 1,
        ]);
    }
}
