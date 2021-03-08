<?php

namespace App\Admin\properties;

use App\Admin\Notifications\Notification;
use App\Admin\Users\User;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Admin\Notifications\PushNotifications;
use App\Admin\Notifications\UserDevice;
use Cocur\Slugify\Slugify;
use Illuminate\Support\Facades\DB;
//use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Notifications\AddAdvertisementNotification;
use Intervention\Image\Facades\Image;
use App\Admin\Advertisements\Advertisement;
use App\Admin\Filters\Filter;
use App\Admin\Tracking\Tracking;

class PropertiesApiController extends Controller
{
    public $helper;

    public function __construct()
    {
        $this->helper = new ApiHelper();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->helper->validate($request, [
            'long' => 'required',
            'lat' => 'required'
        ]);
        $request->zoom = !empty($request->zoom)? $request->zoom : 1;

        $ads_nearby = $this->get_nearby_ads($request->lat, $request->long, $request->zoom);
        $ads = $ads_nearby->where(function ($query) use ($request) {
            if ($request->has('featured')) {
                $x = $request->featured == "true" ? 1 : -1;
                $query->where('featured', $x);
            }
            if ($request->has('notification_service')) {
                $y = $request->notification_service == "true" ? 1 : 0;
                $query->where('notification_service', $y);
            }
            if ($request->has('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            if ($request->has('title')) {
                $query->where('title', 'like', '%' . $request->title . '%');
            }

            if ($request->has('details')) {
                $query->where('details', 'like', '%' . $request->details . '%');
            }
            if ($request->has('price')) {
                if (!empty($request->price['start'])) {
                    $query->where('price', '>=', $request->price['start']);
                }
                if (!empty($request->price['end'])) {
                    $query->where('price', '<=', $request->price['end']);
                }
            }
            if ($request->has('area')) {
                if (!empty($request->area['start'])) {
                    $query->where('area', '>=', $request->area['start']);
                }
                if (!empty($request->area['end'])) {
                    $query->where('area', '<=', $request->area['end']);
                }
            }
            if ($request->has('filters')) {
                foreach ($request->filters as $filter) {
                    if (!empty($filter['text'])) {
                        $query->WhereHas('adtextdata', function ($query) use ($filter) {
                            $query->where('filter_id', $filter['filter_id']);
                            $query->where('text', $filter['text']);
                        });
                    } else {
                        $query->WhereHas('addata', function ($query) use ($filter) {
                            $query->where('filter_id', $filter['filter_id']);
                            if (!empty($filter['option_id'])) {
                            }
                            if (!empty($filter['options'])) {
                                foreach ($filter['options'] as $option) {
                                    $query->where('option_id', $option);
                                }
                            }
                        });
                    }
                }
            }
        })
            ->where('status', 1)->where('archived', 0)->orderBy('updated_at');
        $ads_count = $ads->count();
        $ads = $ads->limit(50)->get();
        $ads->count = $ads_count;
        if ((int)request()->headers->get('Version') !== 2){
            return $this->helper->output($ads);
        }
        //v2
        return $this->helper->output(['count' => $ads_count, 'ads' => $ads]);

    }

   public function get_nearby_ads($latitude, $longitude, $zoom)
    {

        $max = 591657.5505 / (2 ** ($zoom - 1)) / 20;
        $max_distance = (int)request()->headers->get('Version') !== 2 ?  100 : $max;
        return $this->haversine($latitude, $longitude, $max_distance, 'kilometers');
    }

    public function haversine($enter_lat, $enter_lng, $max_distance = 100, $units = 'kilometers')
    {

        if (empty($enter_lat)) {
            $lat = 0;
        }
        if (empty($enter_lng)) {
            $lng = 0;
        }
        /*
         *  Allow for changing of units of measurement
         */
        switch ($units) {
            case 'miles':
                //radius of the great circle in miles
                $gr_circle_radius = 3959;
                break;
            case 'kilometers':
                //radius of the great circle in kilometers
                $gr_circle_radius = 6371;
                break;
        }
        return Advertisement::where('status', 1)->where('archived', 0)->whereRaw(DB::raw("( $gr_circle_radius * acos( cos( radians($enter_lat) ) * cos( radians( ad_lat ) )  * cos( radians( ad_long ) - radians($enter_lng) ) + sin( radians($enter_lat) ) * sin( radians( ad_lat ) ) ) ) < $max_distance "));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request)
    {
        $this->helper->validate($request, [
            'details' => 'required',
           // 'user_id' => 'required',
            'category_id' => 'required',
            'ad_long' => 'required',
            'ad_lat' => 'required',
            'price' => 'required',
            'area' => 'required',
        ]);

        $user = auth()->user()->id;
        $user = User::find($user);
        $bouquet = Tracking::where('user_id',$user->id)->first();
        //check if user had a Bouquet ????
        if ($user->id == null && $bouquet == null) {
            $error = new \stdClass();
            $error->status = 0;
            $error->message = "تم حجب حسابك لمخالفتك شروط الاستخدام";
            response()->json($error)->send();
            exit;
        }else{

                    $ads = Advertisement::where('created_at', '>', Carbon::now()->subDay())->where("created_at", "<", Carbon::now())->count();
        //        if ($ads == $user->max) {
        //            $error = new \stdClass();
        //            $error->status = 0;
        //            $error->message = "تم تجاوز الحد الأقصي من الاعلانات المسموح بها خلال ال ٢٤ ساعة الحالية";
        //            response()->json($error)->send();
        //            exit;
        //        }
        $ad = new Advertisement();

        $this->setAdvertisementData($request, $ad);
        $ad->save();

        //check if bouquet is expired or not ????
        $time = strtotime(date("Y/m/d"));
        // Add 1 month to the current date
        $one_month_plus = date("Y-m-d", strtotime("+1 month", $time));
        
        $date = date("Y-m-d");
        $expire = strtotime("today midnight");
        $today = strtotime("today midnight");
        if($today <= $expire){
            if($bouquet->available_ads > 0 ){
                //decrease one from available ads
                $track = $bouquet->available_ads - 1;
                $bouquet->available_ads = $track;
                //check if there is photo service or not
                if($bouquet->photo_services > 0){
                //decrease one from photo service
                $photo = $bouquet->photo_services - 1;
                $bouquet->photo_services = $track; 
                }
                //$bouquet->end_at=$one_month_plus;
                $bouquet->update();
                //set feature?
                if($request->featured == "true"){
                    //check if there is featured_ads_number or not
                    if($bouquet->featured_ads_number > 0){
                    $bouquet->featured_ads_number = $bouquet->featured_ads_number - 1;
                    $bouquet->update();
                    }
                    else{
                            return response()->json([
                            'msg' => "featured_ads_number finished",
                            'data' => [],
                            'status' => 404]);
                    }
                }

                elseif($request->notification_service == "true"){
                    if($bouquet->mobile_notification > 0){
                    $bouquet->mobile_notification  = $bouquet->mobile_notification - 1;
                    $bouquet->update();
                    }else{
                            return response()->json([
                            'msg' => "notification_service finished",
                            'data' => [],
                            'status' => 404]);
                    }
                }
                //eatured == "false"
                else{
                            return response()->json([
                            'msg' => "Unauthenticated",
                            'data' => [],
                            'status' => 404]);

                }
                // else{
                //     return response()->json([
                //             'msg' => "notification_service or featured finished",
                //             'data' => [],
                //             'status' => 404]);
                // }



                if ($request->has('filters')) {
                foreach ($request->filters as $filter) {
                if (!empty($filter['option_id'])) {
                            $ad_data = new AdsData();
                            $ad_data->filter_id = $filter['filter_id'];
                            $ad_data->option_id = $filter['option_id'];
                            $ad->addata()->save($ad_data);
                        }
                if (!empty($filter['text'])) {
                            $ad_text = new AdsTextData();
                            $ad_text->filter_id = $filter['filter_id'];
                            $ad_text->text = $filter['text'];
                            $ad->adtextdata()->save($ad_text);
                        }
                if (!empty($filter['options'])) {

                            foreach ($filter['options'] as $option) {
                                $ad_data = new AdsData();
                                $ad_data->filter_id = $filter['filter_id'];
                                $ad_data->option_id = $option;
                                $ad->addata()->save($ad_data);
                            }
                        }
                    }
                }             
            return response()->json([
            'msg' => "success",
            'data' => $ad,
            'status' => 200
            ]);
            }else{
            return response()->json([
            'msg' => "The package is over",
            'data' => [],
            'status' => 404
            ]);
            }
        } else {
        return response()->json([
            'msg' => "DATE IS expired",
            'data' => [],
            'status' => 404
        ]);
        }            
        }


    



        // $user = User::Where('email', 'ads-requests@aqarito.com')->first();
        // if (!$user) {
        //     $user = User::create([
        //         'mobile'            => '00',
        //         'name'              => 'admin',
        //         'email'             => 'ads-requests@aqarito.com',
        //         'account_type_id'   => 0,
        //         'mobile_code'       => 0,
        //         'password'          => bcrypt('000')
        //     ]);
        // }
        // $user->notify(new AddAdvertisementNotification($ad));

        //return $this->helper->output($ad);
    }


        public function setAdvertisementData(Request $request, Advertisement $advertisement)
    {
        if($request->featured == "true"){
            $advertisement->featured = 1;
        }else{
            $advertisement->featured = -1;
        }
        if($request->notification_service == "true"){
            $advertisement->notification_service = 1;
        }else{
            $advertisement->notification_service = 0;
        }
        if ($request->has('details')) {
            $advertisement->details = $request->details;
        }
        if ($request->has('type')) {
            $advertisement->type = $request->type;
        }
        if ($request->has('property_type')) {
            $advertisement->property_type = $request->property_type;
        }
        if ($request->has('city_id')) {
            // $advertisement->city_id = $request->city_id;
        }
        if ($request->has('promoted')) {
            $advertisement->promoted = $request->promoted;
        }
        // if ($user_id) {
        //     $advertisement->user_id = auth()->user()->id;
        // }
        if ($request->has('category_id')) {
            $advertisement->category_id = $request->category_id;
        }
        if ($request->has('contact')) {
            $advertisement->contact = $request->contact;
        }
        if ($request->has('ad_long')) {
            $advertisement->user_id = auth()->user()->id;
            $advertisement->ad_long = $request->ad_long;
        }
        if ($request->has('ad_lat')) {
            $advertisement->ad_lat = $request->ad_lat;
        }
        if ($request->has('location')) {
            $advertisement->location = $request->location;
        }
        if ($request->has('price')) {
            $advertisement->price = $request->price;
        }
        if ($request->has('area')) {
            $advertisement->area = $request->area;
        }

        if ($request->has('title')) {
            $advertisement->title = $request->title;

            if (isset($advertisement->slug)){
                $slug = $this->SlugMe($advertisement->title);
                if (Advertisement::where('slug', $slug)->where('id', '!=', $advertisement->id)->count() > 0) {
                    $int = 1;
                    $slug = $this->SlugMe($request->title.$int);
                    while (Advertisement::where('slug', $slug)->count() > 0) {
                        $int = $int + 1;
                        $slug = $this->SlugMe($request->title.$int);
                    }
                }
            }else{
                $slug = $this->SlugMe($request->title);
                if (Advertisement::where('slug', $slug)->count() > 0) {
                    $int = 1;
                    $slug = $this->SlugMe($request->title.$int);
                    while (Advertisement::where('slug', $slug)->count() > 0) {
                        $int = $int + 1;
                        $slug = $this->SlugMe($request->title.$int);
                    }
                }
            }
            $advertisement->slug = $slug;
        }

        if ($request->images) {
            $temp = [];
            if (is_array($request->images)) {
                foreach ($request->images as $image) {
                    if (!empty($image['image'])) {
                        $image = $this->helper->saveBase64ImageForAds($image['image'], $image['ext']);
                        $img = Image::make(public_path('uploads/images/' . $image));
                        $img->resize(500, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $img->save(public_path('uploads/images/' . $image));
                        $this->helper->watermark($image);
                    } else {
                        $image = explode('images/', $image)[1];
                    }
                    $temp[] = 'images/' . $image;
                }
            }
            $advertisement->images = $temp;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


        public static function SlugMe($string)
    {
        if (!is_null($string)) {
            $slug = new Slugify(['regexp' => '/([^\p{Arabic}a-zA-Z0-9]+|-+)/u']);
            $slug->addRules(array(
                'أ' => 'أ',
                'ب' => 'ب',
                'ت' => 'ت',
                'ث' => 'ث',
                'ج' => 'ج',
                'ح' => 'ح',
                'خ' => 'خ',
                'د' => 'د',
                'ذ' => 'ذ',
                'ر' => 'ر',
                'ز' => 'ز',
                'س' => 'س',
                'ش' => 'ش',
                'ص' => 'ص',
                'ض' => 'ض',
                'ط' => 'ط',
                'ظ' => 'ظ',
                'ع' => 'ع',
                'غ' => 'غ',
                'ف' => 'ف',
                'ق' => 'ق',
                'ك' => 'ك',
                'ل' => 'ل',
                'م' => 'م',
                'ن' => 'ن',
                'ه' => 'ه',
                'و' => 'و',
                'ي' => 'ي',
            ));
            return $slug->slugify($string);
        }
    }


    public function Tracking(Request $request)
    {
        $user_id = auth()->user()->id;
        $bouquet = Tracking::where('user_id',$user_id)->get();

        return response()->json([
            'msg' => "success",
            'data' => $bouquet,
            'status' => 200
        ]);
        
        
    }

}
