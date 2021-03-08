<?php

namespace App\Admin\Services;

use Illuminate\Http\Request;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;

class ServiceApiController extends Controller
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
    public function index()
    {
        $service = Service::all();
        return $this->helper->output($service);
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
        $this->helper->validate($request, [
            'city' => 'required',
            'mobile' => 'required',
            'inquiry' => 'required',
            'service_id' => 'required',
        ]);

        $service = new ServiceInquiry;
        $service->city = $request->city;
        $service->mobile = $request->mobile;
        $service->inquiry = $request->inquiry;
        $service->service_id = $request->service_id;
        $service->save();
        
        return $this->helper->output($service);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
