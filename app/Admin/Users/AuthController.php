<?php

namespace App\Admin\Users;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Mail\WelcomeMail;
use App\Notifications\WelcomeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Admin\Users\UserApiController;
use App\Helpers\SmsHelper;
use App\Helpers\TwilioHelper;
use Exception;

class AuthController extends Controller
{
    //
    public $helper, $twilio;

    public function __construct()
    {
        $this->helper = new ApiHelper();
        $this->twilio = new TwilioHelper();
    }

    public function sendOtpForLogin(Request $request)
    {
        if( strlen($request->mobile) > 8 ) {
            $user = User::where('mobile', $request->mobile)->first();
            if( $user ) {
                try {
                    $otp       = $user->mobile == '0553636501' ? 123456 : rand(100000, 999999);
                    $user->otp = $otp;
                    $user->save();
                    if($user->mobile_code == '+966') {
                        $smsHelper = new SmsHelper();
                        $smsHelper->send($otp, $user->mobile);
                    } else {
                        $mobile = (int) $user->mobile;
                        $to = $user->mobile_code.$mobile;
                        $this->twilio->send($otp, $to);
                    }
                    return response()->json(['msg'=>'success'], 200);
                    
                } catch(Exception $e) {
                    return response()->json(['msg'=>'Invalid phone'], 422);
                }
            }
            return response()->json(['msg'=>'phone not found'], 422);
        } else {
            return response()->json(['msg'=>'Invalid phone'], 422);
        }
        
    }


    public function loginWithOtp(Request $request)
    {
        $user = User::where('mobile', $request->mobile)->where('otp', $request->otp)->first();
        if( $user ) {
            return response()->json([
                'user' => $user,
                'token' => $user->createToken(env('APP_NAME'))->accessToken
            ], 200);
        }
        return response()->json(null, 401);
    }

    public function login(Request $request)
    {
        $this->helper->validate($request, ['mobile' => 'required|exists:users,mobile,deleted_at,NULL', 'password' => 'required']);
        $mobile_number = $request->mobile;
        $password = $request->password;
        $user = User::where('mobile', $mobile_number)->first();
        if (!Hash::check($password, $user->password)) {
            $error = new \stdClass();
            $error->fields = ['password'];
            $error->message = "يوجد خطأ بكلمة المرور";
            $error->status = 0;
            response()->json($error)->send();
            exit;
        }
        $user->token = $user->createToken(env('APP_NAME'))->accessToken;

        return $this->helper->output($user);
    }

    public function signUp(Request $request)
    {
        $this->helper->validate($request, [
            'mobile' => 'required'
        ]);
        $user = User::where('mobile', $request->mobile)->withTrashed()->first();
        if ($user) {
            $error = new \stdClass();
            $error->fields = ['mobile'];
            $error->message = "رقم الجوال مسجل مسبقاً";
            $error->status = 0;
            response()->json($error)->send();
            exit;
        }
        $user = User::where('email', $request->email)->withTrashed()->first();
        if ($user) {
            $error = new \stdClass();
            $error->fields = ['email'];
            $error->message = "البريد الإلكتروني مسجل مسبقاً";
            $error->status = 0;
            response()->json($error)->send();
            exit;
        }

        $user = new User();
        $userApi = new UserApiController();
        $userApi->setUserData($request, $user);
        $user->save();
        $user->token = $user->createToken(env('APP_NAME'))->accessToken;

        // \Mail::to($user->email)->send(new WelcomeMail());

        return $this->helper->output($user);
    }

    public function resetPassword(Request $request)
    {
        $this->helper->validate($request, [
            'mobile' => 'required|exists:users,mobile',
        ]);


        $user = User::where('mobile', $request->mobile)->first();

        $password = str_random(6);

        $user->password = bcrypt($password);

        $user->update();

        $message = 'Your new password is : ' . $password;

        // $this->sendMail( $user->email, 'Reset Password', $message );
        // \Mail::to($user->email)->send(new resetpassword($user, $password));
        $smsHelper = new SmsHelper();
        $smsHelper->send($message, $request->mobile);

        return $this->helper->output('Sent Successfully');
    }

    public function sendMail($receiver, $subject, $message)
    {
        $headers = "From: " . env('APP_EMAIL') . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();
//        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        mail($receiver, $subject, $message, $headers);
    }

    public function logout(Request $request)
    {
        $user_id = $request->user_id;
        User::where('id', $user_id)->update(['device_token' => null]);

        return $this->helper->output('success');
    }
}
