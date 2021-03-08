<?php

namespace App\Admin\Users;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\SmsHelper;
use App\Helpers\TwilioHelper;
use App\Admin\Advertisements\Advertisement;

class UserApiController extends Controller
{


    public $helper, $twilio;

    public function __construct()
    {
        $this->helper = new ApiHelper();
        $this->twilio = new TwilioHelper();
    }

    public function index()
    {
        //
        $this->helper->validate(request(), ['user_id' => 'required']);

        $users = User::select('id', 'name', 'email', 'mobile')->where('id', '!=', request('user_id'))->get();

        return $this->helper->output($users);
    }


    public function setUserData(Request $request, User $user)
    {
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        if ($request->mobile_code) {
            $user->mobile_code = $request->mobile_code;
        }

        if ($request->account_type_id) {
            $user->account_type_id = $request->account_type_id;
        }

        if ($request->name) {
            $user->name = $request->name;
        }
        if ($request->mobile) {
            if ($request->user() && $request->user()->mobile != $request->mobile) {
                $this->helper->validate($request, ['mobile' => 'unique:users']);
            }
            $user->mobile = $request->mobile;
        }
        if ($request->password) {
             $user->password = bcrypt($request->password);
        }
        if ($request->email) {
            if ($request->user() && $request->user()->email != $request->email) {
                $this->helper->validate($request, ['email' => 'unique:users']);
            }
            $user->email = $request->email;
        }
        if ($request->has('notify')) {
            $user->notify = $request->notify;
        }
        if ($request->has('avatar')) {
            $user->avatar = $this->helper->saveBase64Image($request->avatar['image'], $request->avatar['ext']);
        }
    }


    public function show($id)
    {
        $user = User::where('id', $id)->select(['id', 'avatar', 'mobile', 'created_at', 'name'])->first();
        $ads = Advertisement::where('user_id', $id)->where('status', 1)->orderBy('id', 'DESC')->get();
        $user->ads = $ads;
        return $this->helper->output($user);

    }

    public function update()
    {
        //
        //        $this->helper->validate( request(), [ 'email' => 'required','mobile'=>'required','password'=>'required','notify'=>'required' ] );

        $user = User::find(request('user_id'));

        $this->setUserData(request(), $user);

        $user->update();

        return $this->helper->output($user);
    }


    public function profile()
    {
        return $this->helper->output(auth()->user());
    }

    public function registerDevice(Request $request)
    {
        $this->helper->validate($request, ['user_id' => 'required', 'token' => 'required']);

        User::where('device_token', $request->token)->where('id', '!=', $request->user_id)->update(['device_token' => null]);

        $user = User::find($request->user_id);
        $user->device_token = $request->token;
        $user->update();

        return $this->helper->output('Device Token Is Set');

    }

    public function toggleNotify(Request $request)
    {

        $user = User::find($request->user_id);
        $user->notify = 1 - $user->notify;

        $user->update();

        return $this->helper->output($user);
    }

    public function blacklist(Request $request)
    {
        $this->helper->validate($request, ['field' => 'required', 'lang' => 'required']);
        $user = User::where('name', $request->field)
            ->orWhere('email', $request->field)
            ->orWhere('mobile', $request->field)
            ->orWhere('id', $request->field)
            ->first();
        if ($user && $user->blacklist) {
            $message = ($request->lang == 'ar') ? 'حساب محظور' : 'Account is blacklisted';
        } else {
            $message = ($request->lang == 'ar') ? 'حساب غير محظور' : 'Account is not blacklisted';
        }
        return $this->helper->output($message);
    }
    
    public function sendUpdateOTP(Request $request)
    {
        $this->validate($request, [
            'mobile' => 'required|unique:users,mobile,' . auth()->user()->id ,
            'country_code' => 'required|max:5'
        ]);
        
        $otp = OTP::where('mobile', request('mobile'))->first();
        
        if($otp) {
            $otp->otp = rand(100000, 999999);
            $otp->save();            
        } else {
            $otp = OTP::create([
                'mobile'    => request('mobile'),
                'otp'       => rand(100000, 999999)
            ]);
        }

        if (request('country_code') == '+966') {
            $smsHelper = new SmsHelper();
            $smsHelper->send($otp->otp, $otp->mobile);
        } else {
            $mobile = (int)$otp->mobile;
            $to = request('country_code') . $mobile;
            $this->twilio->send($otp->otp, $to);
        }
        return $this->helper->output('the message is sent to new mobile');
    }
    
    public function updateMobile(Request $request)
    {
        $this->validate($request, [
            'mobile' => 'required|string|min:8|max:12',
            'country_code' => 'required|max:5',
            'otp' => 'required|digits:6'
        ]);
        
        $otp = OTP::where('mobile', request('mobile'))->where('otp', request('otp'))->first();
        
        if(!$otp) {
            return $this->helper->output('incorrect otp');
        }
        
        $otp->verified = 1;
        $otp->save();
        
        $user = auth()->user();
        $user->mobile_code = request('country_code');
        $user->mobile = request('mobile');
        $user->save();
        
        return $this->helper->output($user);
    }
}
