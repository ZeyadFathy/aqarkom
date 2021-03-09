<?php $__env->startSection('PageTitle', $advertisement['title'] ); ?>
<?php $__env->startSection('content'); ?>

    <!-- Titlebar
================================================== -->
    <div id="titlebar" class="property-titlebar margin-bottom-0">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <a href="<?php echo e(\Illuminate\Support\Facades\URL::previous(), false); ?>" class="back-to-listings"></a>
                    <div class="property-title">
                        <h2><?php echo e($advertisement['title'], false); ?> <span class="property-badge"><?php echo e(\App\Admin\Categories\Category::find($advertisement['category_id'])->title, false); ?></span></h2>
                        <span>
						<a href="#location" class="listing-address">
							<i class="fa fa-map-marker"></i>
							<?php echo e($advertisement['location'], false); ?>

						</a>
                            <a href="#" class="listing-address">
							<i class="fa fa-clock-o"></i>
							<?php echo e(\Carbon\Carbon::parse($advertisement['created_at'])->diffForHumans(), false); ?>

						</a>
					</span>
                    </div>
                    <div class="property-pricing">
                        <div class="property-price"><?php echo e(number_format($advertisement['price']), false); ?> ريال</div>
                        <div class="sub-price"><i class="fa fa-eye"> <?php echo e($views->views, false); ?></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Content
    ================================================== -->
    <div class="container">
        <div class="row margin-bottom-50">
            <div class="col-md-12">
                <!-- Slider -->
                <div class="property-slider default" style="direction:ltr">
                    <?php if(isset($advertisement['images']) && !is_null($advertisement['images'])): ?>
                        <?php $__currentLoopData = $advertisement['images']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="https://old-api.aqarito.net/uploads/<?php echo e($image, false); ?>" data-background-image="https://old-api.aqarito.net/uploads/<?php echo e($image, false); ?>" class="item mfp-gallery"></a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
                <!-- Slider Thumbs -->
                <div class="property-slider-nav">
                    <?php if(isset($advertisement['images']) && !is_null($advertisement['images'])): ?>
                        <?php $__currentLoopData = $advertisement['images']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="item"><img src="https://old-api.aqarito.net/uploads/<?php echo e($image, false); ?>" alt="<?php echo e($image, false); ?>"></div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row">

            <!-- Property Description -->
            <div class="col-lg-8 col-md-7">
                <div class="property-description">
                    <ul class="property-main-features">
                        <li><?php echo app('translator')->getFromJson('app.ad_number'); ?> : <?php echo e($advertisement['id'], false); ?> </li>
                        <li><?php echo app('translator')->getFromJson('app.mobile_seller'); ?> : <?php echo e($advertisement['user']['mobile'], false); ?> </li>
                        <li><?php echo app('translator')->getFromJson('app.area'); ?> <?php echo e($advertisement['area'], false); ?> م²</li>
                    </ul>
                    <!-- Description -->
                    <h3 class="desc-headline"><?php echo app('translator')->getFromJson('app.description'); ?></h3>
                    <div class="show-more">
                        <p>
                            <?php echo e($advertisement['details'], false); ?>

                        </p>
                        <a href="#" class="show-more-button"> <?php echo app('translator')->getFromJson('app.show_more'); ?> <i class="fa fa-angle-down"></i></a>
                    </div>

                    <!-- Details -->
                    <h3 class="desc-headline"><?php echo app('translator')->getFromJson('app.details'); ?></h3>
                    <ul class="property-features margin-top-0">
                        <?php if(isset($advertisement['filters'])): ?>
                            <?php $__currentLoopData = $advertisement['filters']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e(isset($addata->title) ? $addata->title : '', false); ?> :
                                    <?php if($addata->type == 3): ?>
                                        <?php if(isset($addata->options)): ?>
                                            <?php $__currentLoopData = $addata->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span><?php echo e(isset($options->title) ? $options->title : '', false); ?> ,</span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    <?php elseif($addata->type == 1): ?>
                                        <span><?php echo e(isset($addata->text) ? $addata->text : '', false); ?></span>
                                    <?php else: ?>
                                        <?php if(isset($addata->options)): ?>
                                            <?php $__currentLoopData = $addata->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span><?php echo e(isset($options->title) ? $options->title : '', false); ?></span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </ul>

                    <!-- Location -->
                    <h3 class="desc-headline no-border" id="location"><?php echo app('translator')->getFromJson('app.location'); ?> - <a target="_blank" href="https://www.google.com/maps/search/?api=1&query=<?php echo e($advertisement['ad_lat'], false); ?>,<?php echo e($advertisement['ad_long'], false); ?>"><?php echo app('translator')->getFromJson('app.visit_google_maps'); ?></a></h3>
                    <div id="propertyMap-container">
                        <div id="propertyMap" data-latitude="<?php echo e($advertisement['ad_lat'], false); ?>" data-longitude="<?php echo e($advertisement['ad_long'], false); ?>"></div>
                        <a href="#" id="streetView"><?php echo app('translator')->getFromJson('app.StreetView'); ?></a>
                    </div>

                    <!-- Similar Listings Container -->
                    <h3 class="desc-headline no-border margin-bottom-35 margin-top-60"><?php echo app('translator')->getFromJson('app.similar_ads'); ?></h3>
                    <!-- Layout Switcher -->
                    <div class="layout-switcher hidden"><a href="#" class="list"><i class="fa fa-th-list"></i></a></div>
                    <div class="listings-container list-layout">
                    <?php $__currentLoopData = $similar_ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $similar_ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <!-- Listing Item -->
                            <div class="listing-item">

                                <a href="<?php echo e(route('ads.show',$similar_ad->id), false); ?>" class="listing-img-container">
                                    <div class="listing-badges">
                                        <span><?php echo e($similar_ad->category->title, false); ?></span>
                                    </div>
                                    <div class="listing-img-content">
                                        <span class="listing-price"><?php echo e(number_format($similar_ad->price), false); ?> ريال</span>
                                        
                                    </div>
                                    <img src="https://old-api.aqarito.net/uploads/<?php echo e(isset($similar_ad->images[0]) ? $similar_ad->images[0] : '', false); ?>"
                                         alt="<?php echo e(isset($similar_ad->images[0]) ? $similar_ad->images[0] : '', false); ?>">
                                </a>
                                <div class="listing-content">
                                    <div class="listing-title">
                                        <h4><a href="<?php echo e(route('ads.show',$similar_ad->id), false); ?>"><?php echo e($similar_ad->title, false); ?></a></h4>
                                        <a href="https://maps.google.com/maps?q=<?php echo e($similar_ad->location, false); ?>"
                                           class="listing-address popup-gmaps">
                                            <i class="fa fa-map-marker"></i>
                                            <?php echo e($similar_ad->location, false); ?>

                                        </a>
                                        <a href="<?php echo e(route('ads.show',$similar_ad->id), false); ?>" class="details button border"><?php echo app('translator')->getFromJson('app.details'); ?></a>
                                    </div>
                                    <ul class="listing-details">
                                        <li><?php echo app('translator')->getFromJson('app.area'); ?> <span><?php echo e($similar_ad->area, false); ?> م²</span></li>
                                    </ul>
                                    <div class="listing-footer">
                                        <a href="#"><i class="fa fa-user"></i> <?php echo e($similar_ad->user->name, false); ?>

                                            <?php if($similar_ad->user->verified): ?>
                                                <img src="<?php echo e(url('frontend/'), false); ?>/images/v-min.png" style="max-height: 25px;max-width: 25px" title="<?php echo app('translator')->getFromJson('app.verified'); ?>" alt="<?php echo e($similar_ad->user->name, false); ?>">
                                            <?php endif; ?>
                                        </a>
                                        <span><i class="fa fa-calendar-o"></i> <?php echo e($similar_ad->created_at->diffForHumans(), false); ?></span>
                                    </div>
                                </div>
                                <!-- Listing Item / End -->
                            </div>
                            <!-- Listing Item / End -->
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <!-- Similar Listings Container / End -->
                </div>
            </div>
            <!-- Property Description / End -->

            <!-- Sidebar -->
            <div class="col-lg-4 col-md-5">
                <div class="sidebar sticky right">
                    <!-- Widget -->
                    <div class="widget">
                        <h3 class="margin-bottom-35"><?php echo app('translator')->getFromJson('app.featured_ads'); ?></h3>

                        <div class="listing-carousel outer">
                        <?php $__currentLoopData = $featured_ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featured_ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <!-- Item -->
                                <div class="item">
                                    <div class="listing-item compact">

                                        <a href="<?php echo e(route('ads.show',$featured_ad->id), false); ?>" class="listing-img-container">

                                            <div class="listing-badges">
                                                <?php if($featured_ad->featured == 1): ?>
                                                    <span class="featured"><?php echo app('translator')->getFromJson('app.featured'); ?></span>
                                                <?php else: ?>
                                                    <span class=""></span>
                                                <?php endif; ?>
                                                <span><?php echo e($featured_ad->category->title, false); ?></span>
                                            </div>
                                            <div class="listing-img-content">
                                                <span class="listing-compact-title"><?php echo e($featured_ad->title, false); ?> <i><?php echo e(number_format($featured_ad->price), false); ?> ريال</i></span>
                                                <ul class="listing-hidden-content">
                                                    <li><?php echo app('translator')->getFromJson('app.area'); ?> <span><?php echo e($featured_ad->area, false); ?> م²</span></li>
                                                </ul>
                                            </div>
                                            <img src="https://old-api.aqarito.net/uploads/<?php echo e(isset($featured_ad->images[0]) ? $featured_ad->images[0] : '', false); ?>"
                                                 alt="<?php echo e(isset($featured_ad->images[0]) ? $featured_ad->images[0] : '', false); ?>">
                                        </a>
                                    </div>
                                </div>
                                <!-- Item / End -->
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <!-- Widget / End -->
                </div>
            </div>
            <!-- Sidebar / End -->
        </div>
    </div>
    <!-- Footer
    ================================================== -->
    <div class="margin-top-55"></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>