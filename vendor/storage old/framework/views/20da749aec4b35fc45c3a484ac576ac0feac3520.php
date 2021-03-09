<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo e(config('admin.title'), false); ?> | <?php echo e(trans('admin.login'), false); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="<?php echo e(asset('logo.png'), false); ?>" style="background: darkblue"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('login/vendor/bootstrap/css/bootstrap.min.css'), false); ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('login/fonts/font-awesome-4.7.0/css/font-awesome.min.css'), false); ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('login/vendor/animate/animate.css'), false); ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('login/vendor/css-hamburgers/hamburgers.min.css'), false); ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('login/vendor/select2/select2.min.css'), false); ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('login/css/util.css'), false); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('login/css/main.css'), false); ?>">
    <!--===============================================================================================-->
</head>
<body>

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <div class="login100-pic js-tilt" data-tilt>
                <img src="<?php echo e(asset('logo.png'), false); ?>" alt="IMG" style=" width: 100%; height: 100%;">
            </div>

            <form class="login100-form validate-form" action="<?php echo e(admin_base_path('auth/login'), false); ?>" method="post">
					<span class="login100-form-title">
						<?php echo e(config('app.name'), false); ?> Login
					</span>


                <div class="wrap-input100 validate-input"
                     data-validate="<?php echo e(($errors->has('username'))?trans('admin.username_error'):trans('admin.username_required'), false); ?>">
                    <input id="username" class="input100" placeholder="<?php echo e(trans('admin.username'), false); ?>" name="username"
                           value="<?php echo e(old('username'), false); ?>">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="<?php echo e(trans('admin.password_required'), false); ?>">
                    <input class="input100" type="password" placeholder="<?php echo e(trans('admin.password'), false); ?>" name="password">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
                </div>
                <input type="hidden" name="_token" value="<?php echo e(csrf_token(), false); ?>">

                <div class="container-login100-form-btn">
                    <button class="login100-form-btn">
                        <?php echo e(trans('admin.login'), false); ?>

                    </button>
                </div>

                
                
                
                
                
                
                
                

            </form>
        </div>
    </div>
</div>


<!--===============================================================================================-->
<script src="<?php echo e(asset('login/vendor/jquery/jquery-3.2.1.min.js'), false); ?>"></script>
<!--===============================================================================================-->
<script src="<?php echo e(asset('login/vendor/bootstrap/js/popper.js'), false); ?>"></script>
<script src="<?php echo e(asset('login/vendor/bootstrap/js/bootstrap.min.js'), false); ?>"></script>
<!--===============================================================================================-->
<script src="<?php echo e(asset('login/vendor/select2/select2.min.js'), false); ?>"></script>
<!--===============================================================================================-->
<script src="<?php echo e(asset('login/vendor/tilt/tilt.jquery.min.js'), false); ?>"></script>
<script>
    $('.js-tilt').tilt({
        scale: 1.1
    })
</script>
<!--===============================================================================================-->
<script src="<?php echo e(asset('login/js/main.js'), false); ?>"></script>
<script>
    <?php if($errors->has('username')): ?>
    showValidate($('#username'));

    <?php endif; ?>
    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }
</script>
</body>
</html>