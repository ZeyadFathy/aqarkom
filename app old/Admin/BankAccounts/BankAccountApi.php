<?php

namespace App\Admin\BankAccounts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\SmsHelper;
use App\Helpers\TwilioHelper;
class BankAccountApi extends Controller
{

    public $twilio;

    public function __construct()
    {
        $this->twilio = new TwilioHelper();
    }

    /**
     * Display a listing of the resource after attempt from auth.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = BankAccount::all();
        return response()->json([
            'msg' => "success",
            'data' => $accounts,
            'status' => true
        ]);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bankAccount = BankAccount::find($id);
        if(!auth()->user()->mobile_code == '+966') {
            $smsHelper = new SmsHelper();
            $smsHelper->send($bankAccount->account_no, auth()->user()->mobile);
        } else {
            $this->twilio->send($bankAccount->account_no, auth()->user()->mobile_code.auth()->user()->mobile);
        }
        return $bankAccount->account_no;
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
