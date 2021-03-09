<?php dd('s'); ?>

<?php $__env->startSection('PageTitle', trans('app.about_us') ); ?>
<?php $__env->startSection('content'); ?>
    <!-- Titlebar
================================================== -->
    <div id="titlebar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2><?php echo e(trans('app.about_us'), false); ?></h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Content
    ================================================== -->
    <div class="container">
        <!-- Blockquote
        ================================================== -->
        <div class="row">
            <div class="col-md-12">
                <!-- Headline -->

                <blockquote>
                    <?php echo e(isset(\App\Admin\Options\Option::where('key','about_us')->first()->value) ? \App\Admin\Options\Option::where('key','about_us')->first()->value : 'لا يوجد', false); ?>

                </blockquote>
            </div>
        </div>
    </div>
    <div class="margin-top-55"></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>