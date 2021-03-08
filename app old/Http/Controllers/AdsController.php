<?php

namespace App\Http\Controllers;

use App\Admin\Advertisements\AdsData;
use App\Admin\Advertisements\AdView;
use App\Admin\Categories\Category;
use Illuminate\Http\Request;
use App\Admin\Advertisements\Advertisement;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $ads = Advertisement::where('status', 1);
        if (\request()->has('ad_id') && !is_null(\request()->get('ad_id'))) {
            $ads->where('id', \request()->get('ad_id'));
        }
        if (\request()->has('search') && !is_null(\request()->get('search'))) {
            $search = \request()->get('search');
            $ads->where('title', 'LIKE', '%'.$search.'%')->orWhere('details', 'LIKE', '%'.$search.'%')->orWhere('location', 'LIKE', '%'.$search.'%');
        }
        if (\request()->has('category_id') && !is_null(\request()->get('category_id'))) {
            $ads->where('category_id', \request()->get('category_id'));
        }
        if (\request()->has('max_price') && !is_null(\request()->get('max_price')) && request()->get('max_price') > 0) {
            $ads->where('price', '<=', \request()->get('max_price'));
        }
        if (\request()->has('min_price') && !is_null(\request()->get('min_price')) && request()->get('min_price') > 0) {
            $ads->where('price', '>=', \request()->get('min_price'));
        }
        if (\request()->has('max_area') && !is_null(\request()->get('max_area')) && request()->get('max_area') > 0) {
            $ads->where('area', '<=', \request()->get('max_area'));
        }
        if (\request()->has('min_area') && !is_null(\request()->get('min_area')) && request()->get('min_area') > 0) {
            $ads->where('area', '>=', \request()->get('min_area'));
        }
        if (\request()->has('order') && !is_null(\request()->order)) {
            $order = \request()->order;
            if ($order == 'low') {
                $ads->orderBy('price', 'asc');
            }
            if ($order == 'high') {
                $ads->orderBy('price', 'desc');
            }
            if ($order == 'newest') {
                $ads->latest();
            }
            if ($order == 'oldest') {
                $ads->oldest();
            }
        }
        $ads->latest();
        $ads = $ads->paginate(20);
        return view('frontend.listings', compact('ads', 'categories'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = '';
        if ($request->has('ad_id') && !is_null($request->ad_id)) {
            $data = $data.'ad_id='.$request->ad_id.'&';
        }
        if ($request->has('search') && !is_null($request->search)) {
            $data = $data.'search='.$request->search.'&';
        }
        if ($request->has('category_id') && !is_null($request->category_id)) {
            $data = $data.'category_id='.$request->category_id.'&';
        }
        if ($request->has('max_price') && !is_null($request->max_price) && $request->max_price > 0) {
            $data = $data.'max_price='.$request->max_price.'&';
        }
        if ($request->has('min_price') && !is_null($request->min_price) && $request->min_price > 0) {
            $data = $data.'min_price='.$request->min_price.'&';
        }
        if ($request->has('max_area') && !is_null($request->max_area) && $request->max_area > 0) {
            $data = $data.'max_area='.$request->max_area.'&';
        }
        if ($request->has('min_area') && !is_null($request->min_area) && $request->min_area > 0) {
            $data = $data.'min_area='.$request->min_area.'&';
        }
        if (\request()->has('order') && !is_null(\request()->order)) {
            $data = $data.'order='.\request()->order.'&';
        }
        return redirect()->to('/ads?'.$data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $advertisement = Advertisement::where('id', $id)->where('status', 1)->with([
            'user:id,email,name,mobile,avatar,verified',
            'adtextdata:id,advertisement_id,text,filter_id', 'adtextdata.adfilter:id,title,type',
        ])->firstOrFail();

        $views = AdView::where('ad_id', $advertisement->id)->first();
        if (!empty($views)) {
            AdView::where('ad_id', $advertisement->id)->increment('views');
        } else {
            $views = new AdView();
            $views->ad_id = $advertisement->id;
            $views->views = 1;
            $views->save();
        }


        $done = array();
        if (!empty($advertisement->addata)) {
            foreach ($advertisement->addata as $data) {
                if (!in_array($data->filter_id, $done)) {
                    $filter_options = array();
                    $done[] = $data->filter_id;
                    $filter = new \StdClass();
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
                    @$filter->title = $data->adfilter->title;
                    @$filter->type = $data->adfilter->type;
                    $filter->text = $data->text;
                    $filters[] = $filter;
                }
            }

            if (isset($filters)) {
                $advertisement->filters = $filters;
            }
        }

        $advertisement = collect($advertisement->toArray())
            ->only([
                'id', 'filters', 'title', 'price', 'area', 'ad_lat', 'ad_long', 'images', 'created_at', 'category_id', 'location', 'user', 'details', 'featured', 'promoted', 'views',
                'related_ads', 'last_update'
            ])
            ->all();
//return $advertisement;
        $similar_ads = Advertisement::where('category_id', $advertisement['category_id'])->where('status', 1)->take(6)->latest()->get();
        $featured_ads = Advertisement::where('featured', 1)->where('status', 1)->take(10)->latest()->get();
        return view('frontend.single', compact('advertisement', 'similar_ads', 'featured_ads','views'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
