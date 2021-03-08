<?php


namespace App\Admin\Users;


use App\Helpers\ApiHelper;
use App\Helpers\SmsHelper;
use App\Helpers\TwilioHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Admin\Tracking\Tracking;
use App\Admin\Bouquet\Bouquet;
class NewAuthController extends Controller
{
    public $helper, $twilio;

    public function __construct()
    {
        $this->helper = new ApiHelper();
        $this->twilio = new TwilioHelper();
    }

    public function register (Request $request)
    {
        $this->helper->validate($request, [
            'mobile'            => 'required|digits_between:8,12|unique:users,mobile',
            'name'              => 'required|string|min:5|max:20',
            'email'             => 'required|email|unique:users,email',
            'account_type_id'   => 'required|exists:account_type,id',
            'mobile_code'      => 'required|max:5',
            'password'          => 'required|min:6|confirmed'
        ]);

        $user = new User();
        $userApi = new UserApiController();
        $userApi->setUserData($request, $user);
        $user->save();
        $user->token = $user->createToken(env('APP_NAME'))->accessToken;

        return $this->helper->output($user);
    }

    public function CreateAccount (Request $request)
    {
        $this->helper->validate($request, [
            'mobile'            => 'required|digits_between:8,12|unique:users,mobile',
            'name'              => 'required|string|min:5|max:20',
            'email'             => 'required|email|unique:users,email',
            'account_type_id'   => 'required|exists:account_type,id',
            'mobile_code'      => 'required|max:5',
            'password'          => 'required|min:6|confirmed'
        ]);

        $user = new User();
        $userApi = new UserApiController();
        $userApi->setUserData($request, $user);
        $user->save();
        $user->token = $user->createToken(env('APP_NAME'))->accessToken;

        //dd($request->available_ads);
        if(!empty($request->available_ads)){
            $bouquet = Bouquet::where('price',0.00)->first();
            $tracking = new Tracking();
            $tracking->user_id = $user->id;
            $tracking->ads_number = $bouquet->ads_number; 
            $tracking->photo_services = $bouquet->photos_services;
            $tracking->available_ads = $request->available_ads;
            $x = $bouquet->social_media == "true" ? 1 : 0;
            $tracking->social_media  = $x;
            $tracking->featured_ads_number  = $bouquet->featured_ads_number;
            $y = $bouquet->mobile_notification == "true" ? 1 : 0;
            $tracking->mobile_notification  = $y;
            $tracking->end_at  = $request->end_at;
            $tracking->save();

        }else{
            return response()->json(['msg'=>'failed',
                                'data' => null
                                ], 404);
        }
        return $this->helper->output($user);
    }

    public function isAccessTokenRevoked($id)
    {
        if ($token = $this->find($id)) {
            return $token->revoked;
        }

        return true;
    }

    public function login(Request $request)
    {
        $this->helper->validate($request, [
            'mobile'    => 'required|digits_between:8,12',
            'password'  => 'required',
        ]);
        $token = auth()->attempt(['mobile' => request('mobile'), 'password' => request('password')]);
        if ($token) {
            $user = User::where('mobile', request('mobile'))->first();
            return response()->json([
                'user' => $user,
                'token' => $user->createToken(env('APP_NAME'))->accessToken
            ], 200);
        }

        return response()->json(null, 401);
    }

    public function forgetPassword(Request $request)
    {
        $this->helper->validate($request, [
            'mobile'    => 'required|digits_between:8,12',
        ]);

        $user = User::where('mobile', request('mobile'))->first();

        if (!$user) {
            return response()->json(null, 404);
        }

        $password = rand(100000, 999999);
        $user->password = bcrypt($password);
        $user->save();

        if($user->mobile_code == '+966') {
            $smsHelper = new SmsHelper();
            $smsHelper->send('كلمة المرور الجديدة :' . $password, $user->mobile);
        } else {
            $mobile = (int) $user->mobile;
            $to = $user->mobile_code.$mobile;
            $this->twilio->send('كلمة المرور الجديدة :' . $password, $to);
        }

        return response()->json('message is sent successfully', 202);
    }
}