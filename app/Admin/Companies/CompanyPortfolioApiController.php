<?php

namespace App\Admin\Companies;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;

class CompanyPortfolioApiController extends Controller
{
    public $helper;

    public function __construct()
    {
        $this->helper = new ApiHelper();
    }


    public function show($id)
    {
        $title = 'title_ar as title';
        $description = 'description_ar as description';


        if (request()->headers->get('lang') === 'en') {
            $title = 'title_en  as title';
            $description = 'description_en  as description';
        }


        $company = CompanyPortfolio::where('id', $id)
            ->select(['id', 'images', $title, $description])
            ->first();
        return $this->helper->output($company);
    }

}
