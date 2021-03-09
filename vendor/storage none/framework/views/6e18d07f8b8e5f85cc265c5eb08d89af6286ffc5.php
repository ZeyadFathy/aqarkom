<!DOCTYPE html>
<head>
    <?php echo $__env->make('frontend.layouts.head', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>
<body>
<!-- Wrapper -->
<div id="wrapper">
    <?php echo $__env->make('frontend.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->yieldContent('content'); ?>

    <?php echo $__env->make('frontend.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->make('frontend.layouts.foot', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>
<!-- Wrapper / End -->
</body>
</html>
