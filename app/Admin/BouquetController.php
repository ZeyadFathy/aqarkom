<?php

namespace App\Admin;

use App\Http\Controllers\Controller;
use App\Infrastructure\Http\Responders\GenericResponder;
use Illuminate\Http\Request;
use App\Admin\Bouquet\Bouquet;
class BouquetController extends Controller
{
    
    public $bouquets;

    public function __construct()
    {
        //$this->bouquet = $bouquet;
    }

    //display all Bouquets
    public function index()
    {
        $bouquets = Bouquet::get(['id','name_en','name_ar','price','discount_end_date','discount','period','ads_number','free_period','photos_services','social_media','featured_ads_number','mobile_notification','color','status']);

        return response()->json([
            'data' => $bouquets,
            'sucess' => true,
        ], 200);
    }
    
    //display single Bouquets
    
    public function show($id)
    {
        $bouquets = Bouquet::where('id',$id)
        ->get(['id','name_en','name_ar','price','discount_end_date','discount','period','ads_number','free_period','photos_services','social_media','featured_ads_number','mobile_notification','color','status']);

        return response()->json([
            'data' => $bouquets,
            'sucess' => true,
        ], 200);
    }
}
