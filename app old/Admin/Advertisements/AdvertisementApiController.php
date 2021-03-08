<?php

namespace App\Admin\Advertisements;
//use App\Admin\Advertisements\Advertisement;
use App\Admin\Users\User;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use Cocur\Slugify\Slugify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Notifications\AddAdvertisementNotification;
use Intervention\Image\Facades\Image;
use App\Admin\Advertisements\Advertisement;
use App\Admin\Filters\Filter;
class AdvertisementApiController extends Controller
{

    /** @var ApiHelper $helper */
    public $helper;

    public function __construct()
    {
        $this->helper = new ApiHelper();
    }
    

    public function index(Request $request)
    {
        $this->helper->validate($request, [
            'long' => 'required',
            'lat' => 'required'
        ]);
        $request->zoom = !empty($request->zoom)? $request->zoom : 1;

        $ads_nearby = $this->get_nearby_ads($request->lat, $request->long, $request->zoom);

        $ads = $ads_nearby->where(function ($query) use ($request) {
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


    public function store(Request $request)
    {dd('sss');
        $this->helper->validate($request, [
            'details' => 'required',
            'user_id' => 'required',
            'category_id' => 'required',
            'ad_long' => 'required',
            'ad_lat' => 'required',
            'price' => 'required',
            'area' => 'required',
        ]);
        $user = User::find($request->user_id);
        if ($user->blacklist) {
            $error = new \stdClass();
            $error->status = 0;
            $error->message = "تم حجب حسابك لمخالفتك شروط الاستخدام";
            response()->json($error)->send();
            exit;
        }
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

        return $this->helper->output($ad);
    }

    public function setAdvertisementData(Request $request, Advertisement $advertisement)
    {
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
        if ($request->has('user_id')) {
            $advertisement->user_id = $request->user_id;
        }
        if ($request->has('category_id')) {
            $advertisement->category_id = $request->category_id;
        }
        if ($request->has('contact')) {
            $advertisement->contact = $request->contact;
        }
        if ($request->has('ad_long')) {
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


    public function show($id)
    {
        $views = AdView::where('ad_id', $id)->first();
        if (!empty($views)) {
            AdView::where('ad_id', $id)->increment('views');
        } else {
            $views = new AdView();
            $views->ad_id = $id;
            $views->views = 1;
            $views->save();
        }
        $advertisement = Advertisement::where('id', $id)->with([
            'user:id,email,name,mobile,mobile_code,avatar,verified',
            'adtextdata:id,advertisement_id,text,filter_id', 'adtextdata.adfilter:id,title,type',
        ])->first();
        $done = array();
        if (!empty($advertisement->addata)) {
            foreach ($advertisement->addata as $data) {
                if (!in_array($data->filter_id, $done)) {
                    $filter_options = array();
                    $done[] = $data->filter_id;
                    $filter = $data->adfilter;
                    $options = AdsData::where('filter_id', $filter->id)->where('advertisement_id', $advertisement->id)->with('adoption')->get();
                    foreach ($options as $option) {
                        $filter_options[] = $option->adoption;
                    }
                    $filter->options = $filter_options;
                    $filters[] = $filter;
                }
            }

            if (!empty($advertisement->adtextdata)) {
                foreach ($advertisement->adtextdata as $data) {
                    $filter = new \StdClass();
                    $filter->id = $data->filter_id;
                    $filter->title = $data->adfilter->title;
                    $filter->type = $data->adfilter->type;
                    $filter->text = $data->text;
                    $filters[] = $filter;
                }
            }

            if (isset($filters)) {
                $advertisement->filters = $filters;
            }
        }
        // $related_ads = $this->get_nearby_ads($advertisement->ad_lat, $advertisement->ad_long, 1)
        //     ->OrWhere('category_id', $advertisement->category_id)->Where('id', '!=', $advertisement->id)->Select(['id', 'images', 'title', 'price'])->limit(4)->get();
        // $advertisement->related_ads = $related_ads;
        $advertisement->views = $advertisement->ad_views->views;
        $advertisement = collect($advertisement->toArray())
            ->only(['id','type','property_type', 'filters', 'title', 'price', 'area', 'ad_lat', 'ad_long', 'images', 'created_at', 'category_id', 'location', 'user', 'details', 'featured', 'promoted', 'views', 'related_ads', 'last_update'])
            ->all();

        return $this->helper->output($advertisement);
    }

    public function update(Request $request, $id)
    {
        Log::notice($request->all());

        $this->helper->validate($request, [
            'user_id' => 'required',
            'city_id' => 'required',
        ]);

        $ad = Advertisement::find($id);

        $this->setAdvertisementData($request, $ad);

        if( $request->has('filters') ) {
            foreach( $request->filters as $filter) {
                if(isset($filter['option_id']) ) {
                    AdsData::where('advertisement_id', $ad->id)->where('filter_id', $filter['filter_id'])->delete();
                    $ad_data            = new AdsData();
                    $ad_data->filter_id = $filter['filter_id'];
                    $ad_data->option_id = $filter['option_id'];
                    $ad->addata()->save($ad_data);
                }

                if(isset($filter['options'])) {
                    AdsData::where('advertisement_id', $ad->id)->where('filter_id', $filter['filter_id'])->delete();
                    foreach($filter['options'] as $option) {
                        $ad_data = new AdsData();
                        $ad_data->filter_id = $filter['filter_id'];
                        $ad_data->option_id = $option;
                        $ad->addata()->save($ad_data);
                    }
                }

            }
        }

        $ad->update();

        return $this->helper->output($ad);
    }


    public function destroy($id)
    {
        Advertisement::where('id', $id)->delete();

        return $this->helper->output('Deleted Successfully');
    }

    public function myads(Request $request)
    {
        $this->helper->validate(request(), ['user_id' => 'required']);
        $ads = Advertisement::where('user_id', request('user_id'))->where('archived', 0)->orderBy('created_at', 'desc')->paginate(20);
        return response()->json([
            'data' => $ads->getCollection(),
            'moreData' => $ads->hasMorePages(),
            'status' => 1
        ]);
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

    public function today_ads()
    {
        dd('s');
        $ads = Advertisement::where('status', 1)->where('archived', 0)->whereBetween('created_at', [Carbon::now()->setTime(0, 0)->format('Y-m-d H:i:s'), Carbon::now()->setTime(23, 59, 59)->format('Y-m-d H:i:s')])
            ->orderBy('created_at')
            ->paginate(20);
        return response()->json([
            'data' => $ads,
            'moreData' => $ads->hasMorePages(),
            'status' => 1
        ]);
    }

    public function featured()
    {
        $ads = Advertisement::where('status', 1)->where('archived', 0)->where('featured', 1)
            ->orderBy('created_at')
            ->paginate(20);
        return response()->json([
            'data' => $ads,
            'moreData' => $ads->hasMorePages(),
            'status' => 1
        ]);
    }

    public function myArchived()
    {
        $ads = Advertisement::where('archived', 1)
            ->where('user_id', auth()->user()->id)
            ->orderBy('created_at')
            ->paginate(20);
        return response()->json([
            'data' => $ads,
            'moreData' => $ads->hasMorePages(),
            'status' => 1
        ]);
    }

    public function archive($id, Request $request)
    {
        $this->helper->validate($request, [
            'reason' => 'required|between:3,200',
        ]);

        $ad = Advertisement::where([
            ['id', '=', $id],
            ['user_id', '=', auth()->user()->id]
        ])->first();

        if (!$ad) {
            return response()->json([
                'data' => 'not found',
                'status' => 0
            ]);
        }

        $ad->archived = 1;
        $ad->archived_reason = request('reason');
        $ad->update();

        return response()->json([
            'data' => $ad,
            'status' => 1
        ]);
    }

    public function view_ad($id)
    {
        AdView::where('ad_id', $id)->firstOrCreate(
            ['ad_id' => $id],
            ['views' => 0]
        );
        AdView::where('ad_id', $id)->increment('views');
        return $this->helper->output("Ad Viewed successfully");
    }

    public function refresh_ad($id)
    {
        $ad = Advertisement::where('id', $id)->update(['updated_at' => Carbon::now()]);
        return $this->helper->output("تم تحديث الاعلان بنجاح");
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

    public function filter(Request $request)
    {
        return Advertisement::where('status', 1)->where('archived', 0)->where(function($query) use ($request){
            if($request->category_id) {
                $query->where('category_id', $request->category_id);
            }

            if($request->city_id) {
                // $query->where('city_id', $request->city_id);
            }
        })->orderBy('updated_at')->limit(20)->get();
    }

    public function show_mobile(Request $request)
    {   
        DB::table('advertisements')->where('id', $request->id)->increment('show_mobile');
        return response()->json(['sucess' => true,], 200);
    }

    public function indexAll(Request $request)
    {
        $x = $request->featured == "true" ? 1 : -1;
     
        $data = DB::table('advertisements')
                ->where('advertisements.status', 1)
                ->where('advertisements.featured',$x)
                ->where('advertisements.ad_lat', $request->property_lat)
                ->where('advertisements.ad_long', $request->property_lng)
                ->leftJoin('ad_views','advertisements.id','=','ad_views.ad_id')
                ->leftJoin('categories','advertisements.category_id','=','categories.id')
                ->leftJoin('ads_filters','advertisements.category_id','=','ads_filters.category_id')
                //->leftJoin('users','users.id','=','advertisements.user_id')

            ->where(function ($query) use ($request) {
            if ($request->has('id')) {
                $query->where('advertisements.id', $request->id);
            }
            if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
            }           
            if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
            }
            if ($request->has('min_area')) {
                $query->where('min_area', $request->min_area);
            }
            if ($request->has('max_area')) {
                $query->where('max_area', $request->max_area);
            }
            if ($request->has('category_id')) {
                $query->where('advertisements.category_id', $request->category_id);
            }

            if ($request->has('sort')) {
                if($request->sort == "min_price"){
                $query->orderBy('price', 'ASC');
                }
                elseif($request->sort == "max_price"){
                $query->orderBy('price', 'DESC');
                }
                elseif($request->sort == "created_at"){
                $query->orderBy('created_at', 'DESC');
                }
                elseif($request->sort == "ad_views"){
                $query->orderBy('views', 'ASC');
                }
            }

        })->select(['advertisements.id','advertisements.type','advertisements.property_type','advertisements.title', 'advertisements.price', 'advertisements.min_area','advertisements.max_area', 'advertisements.ad_lat', 'advertisements.ad_long', 'advertisements.images', 'advertisements.created_at', 'advertisements.category_id', 'advertisements.location','advertisements.details', 'advertisements.featured', 'advertisements.promoted','title_filter','ads_filters.id as filter_id','ads_filters.type'])
            ->paginate($request->per_page);
            if (!empty($data[0]->category_id)) {
            $filter = Filter::where('ads_filters.category_id',$data[0]->category_id)->get();
            $value = [];
            foreach ($data as $value) {
                $value = ['id'=>$value->id ,
                         'type'=>$value->type,
                         'property_type'=>$value->property_type,
                         'price'=>$value->price,
                         'title'=>$value->title,
                         'max_area'=>$value->max_area,
                         'min_area'=>$value->min_area,
                         'featured'=>$value->featured,
                         'ad_lat'=>$value->ad_lat,
                         'ad_long'=>$value->ad_long,
                         'category_id'=>$value->category_id,
                         'images'=>$value->images,
                         'filter'=>$filter
                            ];


            }
                   return response()->json(['msg'=>'success',
                                'data' => $value
                                ], 200);
        }else{
            return response()->json(['msg'=>'failed',
                                'data' => null
                                ], 404);
        }

    }



    public function indexAlls(Request $request)
    {
        $x = $request->featured == "true" ? 1 : -1;
        $data = DB::table('advertisements')
                ->where('status', 1)
                ->where('featured',$x)
                ->where('ad_lat', $request->property_lat)
                ->where('ad_long', $request->property_lng)
                ->leftJoin('ad_views','advertisements.id','=','ad_views.ad_id')
                ->leftJoin('categories','advertisements.category_id','=','categories.id')
                ->leftJoin('ads_filters','advertisements.category_id','=','ads_filters.category_id')

            ->where(function ($query) use ($request) {
            if ($request->has('id')) {
                $query->where('advertisements.id', $request->id);
            }
            if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
            }           
            if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
            }
            if ($request->has('min_area')) {
                $query->where('min_area', $request->min_area);
            }
            if ($request->has('max_area')) {
                $query->where('max_area', $request->max_area);
            }
            if ($request->has('category_id')) {
                $query->where('advertisements.category_id', $request->category_id);
            }

            if ($request->has('sort')) {
                if($request->sort == "min_price"){
                $query->orderBy('price', 'ASC');
                }
                elseif($request->sort == "max_price"){
                $query->orderBy('price', 'DESC');
                }
                elseif($request->sort == "created_at"){
                $query->orderBy('created_at', 'DESC');
                }
                elseif($request->sort == "ad_views"){
                $query->orderBy('views', 'ASC');
                }
            }

        })->Paginate($request->per_page);


        return response()->json(['msg'=>'success','data' => $data], 200);
        //return GenericResponder::make($this->advertisement->indexAll($request->all()));
    }


    public function latest(Request $request)
    {
        $data = DB::table('advertisements')
                ->where('status', 1)
                ->where('featured',-1)
                ->where('ad_lat', $request->property_lat)
                ->where('ad_long', $request->property_lng)
                ->leftJoin('ad_views','advertisements.id','=','ad_views.ad_id')
                ->leftJoin('categories','advertisements.category_id','=','categories.id')
                ->leftJoin('ads_filters','advertisements.category_id','=','ads_filters.category_id')

            ->where(function ($query) use ($request) {
            if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
            }           
            if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
            }
            if ($request->has('id')) {
                $query->where('advertisements.id', $request->id);
            }
            if ($request->has('min_area')) {
                $query->where('min_area', $request->min_area);
            }
            if ($request->has('max_area')) {
                $query->where('max_area', $request->max_area);
            }
            if ($request->has('category_id')) {
                $query->where('advertisements.category_id', $request->category_id);
            }

            if ($request->has('sort')) {
                if($request->sort == "min_price"){
                $query->orderBy('price', 'ASC');
                }
                elseif($request->sort == "max_price"){
                $query->orderBy('price', 'DESC');
                }
                elseif($request->sort == "created_at"){
                $query->orderBy('created_at', 'DESC');
                }
                elseif($request->sort == "ad_views"){
                $query->orderBy('views', 'ASC');
                }
            }

        })->orderBy('advertisements.created_at', 'desc')->take(20);//->Paginate($request->per_page);
        dd($data);
        return response()->json(['msg'=>'success','data' => $data], 200);
    }


}
