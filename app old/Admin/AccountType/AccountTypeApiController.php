<?php

namespace App\Admin\AccountType;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;

class AccountTypeApiController extends Controller
{

    public $helper;

    public function __construct()
    {
        $this->helper = new ApiHelper();
    }

    
    public function index()
    {
        $name = 'name_ar as name';

        if (request()->headers->get('lang') === 'en') {
            $name = 'name_en  as name';
        }
    
        return $this->helper->output(AccountType::select(['id', $name])->get()->toArray());
    }

}
