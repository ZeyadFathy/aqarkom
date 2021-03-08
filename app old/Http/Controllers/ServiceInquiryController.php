<?php

namespace App\Http\Controllers;

use App\Admin\Services\Service;
use App\Admin\Services\ServiceInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceInquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $services = Service::all();
        return view('frontend.ServiceInquiry',compact('services'));
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
        $validator = Validator::make($request->all(),[
            'city' => 'required',
            'mobile' => 'required',
            'inquiry' => 'required',
            'service_id' => 'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        }

        $service = new ServiceInquiry;
        $service->city = $request->city;
        $service->mobile = $request->mobile;
        $service->inquiry = $request->inquiry;
        $service->service_id = $request->service_id;
        $service->save();
        return trans('app.thank_you');
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
