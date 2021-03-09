<?php $__env->startSection('PageTitle', trans('app.download_now') ); ?>
<?php $__env->startSection('content'); ?>
    <div class="margin-bottom-55"></div>
    <p style="text-align: center; font-size: 20px">
        لتتمكن من إضافة او تمييز إعلان عليك تحميل التطبيق أولًا وتسجيل حساب
    </p>
    <div class="margin-top-55"></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>