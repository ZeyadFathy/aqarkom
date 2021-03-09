<!-- Basic Page Needs
================================================== -->
<title><?php if (! empty(trim($__env->yieldContent('PageTitle')))): ?><?php echo $__env->yieldContent('PageTitle'); ?> | <?php endif; ?><?php echo e(env('APP_NAME'), false); ?></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<!-- CSS
================================================== -->
<link rel="stylesheet" href="<?php echo e(url('frontend/'), false); ?>/css/style.css">
<link rel="stylesheet" href="<?php echo e(url('frontend/'), false); ?>/css/colors/green.css" id="colors">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/earlyaccess/droidarabickufi.css" />
<meta property="og:title" content="<?php echo $__env->yieldContent('PageTitle'); ?>">
<meta property="og:image" content="<?php echo e(isset($advertisement['images'][0])?url('uploads/'.$advertisement['images'][0]): url('uploads/logo-background.jpg'), false); ?>">
<meta property="og:description" content="<?php echo e(isset($advertisement['details'])? $advertisement['details']: \App\Admin\Options\Option::where('key','about_us')->first()->value, false); ?>">
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-150731558-1"></script>
<script type="application/javascript">
 window.dataLayer = window.dataLayer || [];
 function gtag(){dataLayer.push(arguments);}
 gtag('js', new Date());
 gtag('config', 'UA-150731558-1');
</script>
