<?php

namespace App\Admin\Cities;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;

class CityApiController extends Controller
{
    public $helper;

    public function __construct()
    {
        $this->helper = new ApiHelper();
    }

    public function index()
    {
        $title = 'title';

        if (request()->headers->get('lang') === 'en') {
            $title = 'title_en  as title';
        }

        $data = City::select(['id', $title, 'rlong', 'rlat', 'vlong', 'vlat'])->with(['regions:id,title,city_id'])
            ->get()->toArray();
        return $this->helper->output($data);
    }
}
