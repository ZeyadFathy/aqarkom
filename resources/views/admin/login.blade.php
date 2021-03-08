<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{config('admin.title')}} | {{ trans('admin.login') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{asset('logo.png')}}" style="background: darkblue"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('login/vendor/bootstrap/css/bootstrap.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('login/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('login/vendor/animate/animate.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('login/vendor/css-hamburgers/hamburgers.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('login/vendor/select2/select2.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('login/css/util.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('login/css/main.css')}}">
    <!--===============================================================================================-->
</head>
<body>

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <div class="login100-pic js-tilt" data-tilt>
                <img src="{{asset('logo.png')}}" alt="IMG" style=" width: 100%; height: 100%;">
            </div>

            <form class="login100-form validate-form" action="{{ admin_base_path('auth/login') }}" method="post">
					<span class="login100-form-title">
						<!-- {{config('app.name')}} -->
                        AQARKOM Login
					</span>


                <div class="wrap-input100 validate-input"
                     data-validate="{{($errors->has('username'))?trans('admin.username_error'):trans('admin.username_required')}}">
                    <input id="username" class="input100" placeholder="{{ trans('admin.username') }}" name="username"
                           value="{{ old('username') }}">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="{{trans('admin.password_required')}}">
                    <input class="input100" type="password" placeholder="{{ trans('admin.password') }}" name="password">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="container-login100-form-btn">
                    <button class="login100-form-btn">
                        {{ trans('admin.login') }}
                    </button>
                </div>

                {{--<div class="text-center p-t-12">--}}
                {{--<span class="txt1">--}}
                {{--Forgot--}}
                {{--</span>--}}
                {{--<a class="txt2" href="#">--}}
                {{--Username / Password?--}}
                {{--</a>--}}
                {{--</div>--}}

            </form>
        </div>
    </div>
</div>


<!--===============================================================================================-->
<script src="{{asset('login/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('login/vendor/bootstrap/js/popper.js')}}"></script>
<script src="{{asset('login/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('login/vendor/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('login/vendor/tilt/tilt.jquery.min.js')}}"></script>
<script>
    $('.js-tilt').tilt({
        scale: 1.1
    })
</script>
<!--===============================================================================================-->
<script src="{{asset('login/js/main.js')}}"></script>
<script>
    @if($errors->has('username'))
    showValidate($('#username'));

    @endif
    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }
</script>
</body>
</html>