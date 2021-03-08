<?php

namespace App\Admin\Users;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\SmsHelper;
use App\Helpers\TwilioHelper;
use Exception;
use Illuminate\Support\Facades\Log;
class OTPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $helper, $twilio;

    public function __construct()
    {
        $this->helper = new ApiHelper();
        $this->twilio = new TwilioHelper();
    }

    public function resend(Request $request)
    {
        $this->helper->validate($request, ['mobile' => 'required']);
        Log::notice($request->mobile);
        $otp = rand(100000, 999999);
        $new = OTP::where('mobile', $request->mobile)->firstOrFail();
        $new->otp = $otp;
        $new->save();
        $smsHelper = new SmsHelper();
        $smsHelper->send($otp, $request->mobile);
        return $this->helper->output("sent");
    }

    public function resendNew(Request $request)
    {
        $this->helper->validate($request, ['mobile_code' => 'required', 'mobile' => 'required']);
        $otp = rand(100000, 999999);
        $new = OTP::where('mobile', $request->mobile)->firstOrFail();
        $new->otp = $otp;
        $new->save();
        $mobile_code = str_replace("'","",$request->mobile_code);
        if($mobile_code == '+966') {
            $smsHelper = new SmsHelper();
            $smsHelper->send($otp, $request->mobile);
        } else {
            $mobile = (int)$request->mobile;
            $this->twilio->send($otp, "{$mobile_code}{$mobile}");
        }
        
        return $this->helper->output("sent");
    }

    public function send(Request $request)
    {
        $this->helper->validate($request, ['mobile' => 'required']);

        if (OTP::where('mobile', $request->mobile)->get()->count() != 0) {
            return response()->json(['msg'=>'phone already exist1'], 422);
        }

        $otp = rand(100000, 999999);
        $new = new OTP();
        $new->mobile = $request->mobile;
        $new->otp = $otp;
        $new->save();
        $smsHelper = new SmsHelper();
        $smsHelper->send($otp, $request->mobile);
        return $this->helper->output("sent");
    }

    public function sendNew(Request $request)
    {


        $this->helper->validate($request, ['mobile' => 'required']);
        if (! preg_match("~^0\d+$~", $request->mobile)) {
            return response()->json(['msg'=>'Invalid phone'], 422);
            // $mob = sprintf("%011s", $request->mobile);
            // $request->mobile =$mob;      
        }else{
            if (User::where('mobile', $request->mobile)->get()->count() != 0) {
                return response()->json(['msg'=>'phone already exist'], 422);
            }
        }



        if (OTP::where('mobile', $request->mobile)->get()->count() != 0) {
            $mobile_otp = OTP::where('mobile', $request->mobile)->first();
            $otp = rand(100000, 999999);
            $mobile_otp->otp = $otp;
            $mobile_otp->save();
        } else {
            if( strlen($request->mobile) > 8 ) {
                $otp = rand(100000, 999999);
                $mobile_otp = new OTP();
                $mobile_otp->mobile = $request->mobile;
                $mobile_otp->otp = $otp;
                $mobile_otp->save();
            } else {
                return response()->json(['msg'=>'Invalid phone'], 422);
            }
        }

        $mobile      = (int)$request->mobile;
        $mobile_code = str_replace("'","",$request->mobile_code);
        try {
            Log::notice("{$mobile_code}{$mobile}");
            if($mobile_code == '+966') {
                $smsHelper = new SmsHelper();
                $smsHelper->send($otp, $request->mobile);
            } else {
                $this->twilio->send($otp, "{$mobile_code}{$mobile}");
            }
            return $this->helper->output("sent");
        } catch (Exception $message) {
            return response()->json(['msg'=>'Invalid phone'], 422);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        $this->helper->validate($request, ['mobile' => 'required', 'otp' => 'required']);
        $data = OTP::where('mobile', $request->mobile)->first();
        if ($data->otp == $request->otp) {
            $data->verified = 1;
            $data->save();
            return $this->helper->output("true");
        } else {
            return response()->json([
                'message' => trans('admin.wrong_otp'),
                'status' => 0,
            ], 200);
        }
    }
}
