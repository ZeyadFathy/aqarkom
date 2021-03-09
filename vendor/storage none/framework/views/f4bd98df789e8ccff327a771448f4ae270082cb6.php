<?php $__env->startSection('PageTitle', 'Aqarito' ); ?>

<?php $__env->startSection('content'); ?>
    <!-- Banner
================================================== -->
    <div class="parallax" data-background="<?php echo e(url('frontend/'), false); ?>/images/home-parallax.jpg" data-color="#36383e" data-color-opacity="0.45" data-img-width="2500" data-img-height="1600">
        <div class="parallax-content">

            <div class="container">
                <div class="row">
                    <div class="col-md-12">

                        <!-- Main Search Container -->
                        <div class="main-search-container">
                            <h2><?php echo app('translator')->getFromJson('app.search_on_the_home_of_your_dreams'); ?></h2>

                            <!-- Main Search -->
                            <form method="post" action="<?php echo e(route('ads.store'), false); ?>" id="main-search-form" autocomplete="on" class="main-search-form">
                            <?php echo e(csrf_field(), false); ?>

                            <!-- Type -->
                                <div class="search-type">
                                    <label class="active"><input class="first-tab" name="tab" checked="checked" type="radio"><?php echo app('translator')->getFromJson('app.what_you_think_of'); ?></label>
                                    <div class="search-type-arrow"></div>
                                </div>
                                <!-- Box -->
                                <div class="main-search-box">
                                    <!-- Main Search Input -->
                                    <div class="main-search-input larger-input">
                                        <input name="ad_id" type="number" class="ico-01" placeholder="<?php echo app('translator')->getFromJson('app.ad_number'); ?>" value=""/>
                                        <input name="search" type="text" class="ico-01" placeholder="<?php echo app('translator')->getFromJson('app.enter_the_address_for_example_street_city'); ?>" value=""/>
                                        <button class="button"><?php echo app('translator')->getFromJson('app.search'); ?></button>
                                    </div>

                                    <!-- Row -->
                                    <div class="row with-forms">
                                        <!-- Property Type -->
                                        <div class="col-md-4">
                                            <select data-placeholder="<?php echo app('translator')->getFromJson('app.what_are_you_looking_for'); ?>" class="chosen-select-no-single" name="category_id">
                                                <option label="blank"></option>
                                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($category->id, false); ?>"><?php echo e($category->title, false); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <!-- Min Price -->
                                        <div class="col-md-4">
                                            <!-- Select Input -->
                                            <div class="select-input">
                                                <input name="max_price" type="text" step="1" pattern="[0-9]*" placeholder="<?php echo app('translator')->getFromJson('app.max_price'); ?>" data-unit="ريال">
                                            </div>
                                            <!-- Select Input / End -->
                                        </div>
                                        <!-- Max Price -->
                                        <div class="col-md-4">
                                            <!-- Select Input -->
                                            <div class="select-input">
                                                <input name="min_price" type="text" step="1" pattern="[0-9]*" placeholder="<?php echo app('translator')->getFromJson('app.min_price'); ?>" data-unit="ريال">
                                            </div>
                                            <!-- Select Input / End -->
                                        </div>
                                    </div>
                                    <!-- Row / End -->
                                </div>
                                <!-- Box / End -->
                            </form>
                            <!-- Main Search -->
                        </div>
                        <!-- Main Search Container / End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content
    ================================================== -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="headline margin-bottom-25 margin-top-65"><?php echo app('translator')->getFromJson('app.newly_added'); ?></h3>
            </div>
            <!-- Carousel -->
            <div class="col-md-12">
                <div class="carousel">
                <?php $__currentLoopData = $ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <!-- Listing Item -->
                        <div class="carousel-item">
                            <div class="listing-item">
                                <a href="<?php echo e(route('ads.show',$ad->id), false); ?>" class="listing-img-container">
                                    <div class="listing-badges">
                                        <?php if($ad->featured == 1): ?>
                                            <span class="featured"><?php echo app('translator')->getFromJson('app.featured'); ?></span>
                                        <?php else: ?>
                                            <span></span>
                                        <?php endif; ?>
 
                                    </div>
                                    <div class="listing-img-content">
                                        <span class="listing-price"><?php echo e(number_format($ad->price), false); ?> ريال</span>
                                        
                                        
                                    </div>
                                    <div class="listing-carousel">
                                        <?php if(isset($ad->images) && !is_null($ad->images)): ?>
                                            <?php $__currentLoopData = $ad->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div><img style="max-height: 373px; min-height: 373px" src="https://old-api.aqarito.net/uploads/<?php echo e($image, false); ?>" alt="<?php echo e($image, false); ?>"></div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </div>
                                </a>
                                <div class="listing-content">
                                    <div class="listing-title">
                                        <h4><a href="<?php echo e(route('ads.show',$ad->id), false); ?>"><?php echo e($ad->title, false); ?></a></h4>
                                        <a href="https://maps.google.com/maps?q=<?php echo e($ad->location, false); ?>"
                                           class="listing-address popup-gmaps">
                                            <i class="fa fa-map-marker"></i>
                                            <?php echo e($ad->location, false); ?>

                                        </a>
                                    </div>
                                    <ul class="listing-features">
                                        <li><?php echo app('translator')->getFromJson('app.area'); ?> <span><?php echo e($ad->area, false); ?> م²</span></li>
                                    </ul>
                                    <div class="listing-footer">
                                        <a href="#"><i class="fa fa-user"></i> <?php echo e($ad->user->name, false); ?>

                                            <?php if($ad->user->verified): ?>
                                                <img src="<?php echo e(url('frontend/'), false); ?>/images/v-min.png" style="max-height: 25px;max-width: 25px" title="<?php echo app('translator')->getFromJson('app.verified'); ?>" alt="<?php echo e($ad->user->name, false); ?>">
                                            <?php endif; ?>
                                        </a>
                                        <span><i class="fa fa-calendar-o"></i> <?php echo e($ad->created_at->diffForHumans(), false); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Listing Item / End -->
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <!-- Carousel / End -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>