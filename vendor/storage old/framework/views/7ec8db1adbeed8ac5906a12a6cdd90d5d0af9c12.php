<?php $__env->startSection('PageTitle', 'Aqarito - Bouquets' ); ?>

<?php $__env->startSection('content'); ?>
    <!-- Content
    ================================================== -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="headline margin-bottom-25 margin-top-65">الباقات</h3>
                <div class="row bouquets">
                    <?php $__currentLoopData = $bouquets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bouquet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4">
                            <div class="bouquet" style="background-color: <?php echo e($bouquet->color, false); ?>">
                                <h3><?php echo e($bouquet->name_ar, false); ?></h3>
                                <h3 class="price"><?php echo e($bouquet->price, false); ?> ريال</h3>
                                <hr>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>فترة صلاحية الباقة</td>
                                            <td><?php echo e($bouquet->period, false); ?> شهر</td>
                                        </tr>
                                        <tr>
                                            <td>عقارات المعلن</td>
                                            <td><?php echo e($bouquet->ads_number, false); ?> اعلان</td>
                                        </tr>
                                        <tr>
                                            <td>خدمة التصوير</td>
                                            <td><?php echo e($bouquet->photos_services, false); ?> خدمة</td>
                                        </tr>
                                        <tr>
                                            <td>التواصل الاجتماعى</td>
                                            <td><?php echo e($bouquet->social_media, false); ?></td>
                                        </tr>
                                        <tr>
                                            <td>اعلان مميز</td>
                                            <td><?php echo e($bouquet->featured_ads_number, false); ?> اعلان</td>
                                        </tr>
                                        <tr>
                                            <td>الاشعارات</td>
                                            <td><?php echo e($bouquet->mobile_notification, false); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <h5><?php echo e($bouquet->free_period, false); ?> شهور مجانا</h5>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>