<?php

namespace App\Admin\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ApiHelper;

class ReportApiController extends Controller
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
        //
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
            'ad_id' => 'required',
            'user_id' => 'required'
        ]);
        $reported = Report::Where('user_id', $request->user_id)->Where('ad_id', $request->ad_id)->first();
        if (empty($reported)) {
            $report = new Report();
            $report->ad_id = $request->ad_id;
            $report->user_id = $request->user_id;
            if ($request->has('reason')) {
                $report->reason = $request->reason;
            }
            $report->save();
            $message = "تم التبليغ بنجاح";
            return response()->json([
                'data' => $message,
                'status' => 1,
            ], 200);
        } else {
            $message = "لقد قمت بالابلاغ مسبقاً عن هذا الاعلان";
            return response()->json([
                'message' => $message,
                'status' => 0,
            ], 200);
        }
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
