<?php

namespace App\Admin\Categories;

use App\Admin\Advertisements\Advertisement;
use App\Admin\Advertisements\AdvertisementApiController;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class CategoryApiController extends Controller
{
    public $helper;

    public function __construct()
    {
        $this->helper = new ApiHelper();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $title = 'title_ar as title';

        if (request()->headers->get('lang') === 'en') {
            $title = 'title_en  as title';
        }

        $obj = Category::select(['id', $title, 'icon','property_type','property_for'])->with(['filters:id,category_id,title,type', 'filters.options:id,filter_id,title'])
            ->get()->toArray();
        return $this->helper->output($obj);
    }

    public function prependAll($obj, $lang)
    {
        $all = new \stdClass();
        $all->id = -1;
        $all->title = Lang::get('admin.all', [], $lang);
        foreach ($obj->categories as $key => $category) {
            if (count($obj->categories[$key]['models']) > 0) {
                array_unshift($obj->categories[$key]['models'], $all);
            }

            if (count($obj->categories[$key]['brands']) > 0) {
                array_unshift($obj->categories[$key]['brands'], $all);
            }

            foreach ($obj->categories[$key]['brands'] as $key2 => $value) {
                $obj->categories[$key]['brands'][$key2] = (array)$obj->categories[$key]['brands'][$key2];
                if (array_has($obj->categories[$key]['brands'][$key2], 'types')) {
                    array_unshift($obj->categories[$key]['brands'][$key2]['types'], $all);
                }
            }
            if (count($obj->categories[$key]['subcategories']) > 0) {
                array_unshift($obj->categories[$key]['subcategories'], $all);
            }

        }
        // add all to beg
        if (count($obj->categories) > 0) {
            array_unshift($obj->categories, $all);
        }

        if (count($obj->cities) > 0) {
            array_unshift($obj->cities, $all);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        //
        $title = 'title_ar as title';
        if (request()->headers->get('lang') === 'en') {
            $title = 'title_en  as title';
        }

        $user_id = (request()->user()) ? request()->user()->id : null;
        $ads = Advertisement::where(function ($query) use ($id) {
            if ($id != -1) {
                $query->where('category_id', $id);
            }
            AdvertisementApiController::filterAds($query);
            $query->where('status', 1);
        })->with([
            'user' => function ($query) {
                $query->select('id', 'name')->withTrashed();
            },
            'city' => function ($query) use ($title) {
                $query->select('id', $title)->withTrashed();
            },
        ])->withCount([
            'likes as liked' => function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            },
        ])->select(['id', $title])->orderBy('created_at', 'desc')->paginate(20);

        return response()->json([
            'data' => $ads->getCollection(),
            'moreData' => $ads->hasMorePages(),
            'status' => 1,
        ]);
//        return $this->helper->output( $ads );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
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
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
