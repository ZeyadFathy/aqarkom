<?php $__env->startSection('PageTitle','الاعلانات'); ?>
<?php $__env->startSection('content'); ?>
    <!-- Search
================================================== -->
    <section class="search margin-bottom-50" style="direction:rtl">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Title -->
                    <h3 class="search-title"><?php echo app('translator')->getFromJson('app.search'); ?></h3>
                    <!-- Form -->
                    <!-- Main Search -->
                    <form method="post" action="<?php echo e(route('ads.store'), false); ?>" autocomplete="off">
                        <?php echo e(csrf_field(), false); ?>

                        <div class="main-search-box no-shadow">
                            <!-- Row With Forms -->
                            <div class="row with-forms">
                                <div class="col-md-3">
                                    <div class="main-search-input">
                                        <input type="number" id="ad_id" name="ad_id" placeholder="<?php echo app('translator')->getFromJson('app.ad_id'); ?>" value="<?php echo e(request()->get('ad_id'), false); ?>"/>
                                    </div>
                                </div>
                                <!-- Status -->
                                <div class="col-md-3">
                                    <select data-placeholder="<?php echo app('translator')->getFromJson('app.what_are_you_looking_for'); ?>" class="chosen-select-no-single" name="category_id" id="category_id">
                                        <option value=""><?php echo app('translator')->getFromJson('app.what_are_you_looking_for'); ?></option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id, false); ?>" <?php echo e(((request()->get('category_id') == $category->id ) ? 'selected':''), false); ?>><?php echo e($category->title, false); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <!-- Main Search Input -->
                                <div class="col-md-6">
                                    <div class="main-search-input">
                                        <input type="text" id="name" name="search" placeholder="<?php echo app('translator')->getFromJson('app.enter_the_address_for_example_street_city'); ?>" value="<?php echo e(request()->get('search'), false); ?>"/>
                                        <button type="submit" class="button"><?php echo app('translator')->getFromJson('app.search'); ?></button>
                                    </div>
                                </div>

                            </div>
                            <!-- Row With Forms / End -->
                            <!-- Row With Forms -->
                            <div class="row with-forms">

                                <!-- Min Price -->
                                <div class="col-md-3">

                                    <!-- Select Input -->
                                    <div class="select-input disabled-first-option">
                                        <input type="text" placeholder="<?php echo app('translator')->getFromJson('app.min_area'); ?>" name="min_area" data-unit="م²" value="<?php echo e(request()->get('min_area'), false); ?>">
                                        <select>
                                            <option><?php echo app('translator')->getFromJson('app.min_area'); ?></option>
                                            <option>300</option>
                                            <option>400</option>
                                            <option>500</option>
                                            <option>700</option>
                                            <option>800</option>
                                            <option>1000</option>
                                            <option>1500</option>
                                        </select>
                                    </div>
                                    <!-- Select Input / End -->

                                </div>

                                <!-- Max Price -->
                                <div class="col-md-3">

                                    <!-- Select Input -->
                                    <div class="select-input disabled-first-option">
                                        <input type="text" placeholder="<?php echo app('translator')->getFromJson('app.max_area'); ?>" data-unit="م²" name="max_area" value="<?php echo e(request()->get('max_area'), false); ?>">
                                        <select>
                                            <option><?php echo app('translator')->getFromJson('app.max_area'); ?></option>
                                            <option>300</option>
                                            <option>400</option>
                                            <option>500</option>
                                            <option>700</option>
                                            <option>800</option>
                                            <option>1000</option>
                                            <option>1500</option>
                                        </select>
                                    </div>
                                    <!-- Select Input / End -->

                                </div>


                                <!-- Min Price -->
                                <div class="col-md-3">

                                    <!-- Select Input -->
                                    <div class="select-input disabled-first-option">
                                        <input type="text" placeholder="<?php echo app('translator')->getFromJson('app.min_price'); ?>" value="<?php echo e(request()->get('min_price'), false); ?>" name="min_price" data-unit="ريال">
                                        <select>
                                            <option><?php echo app('translator')->getFromJson('app.min_price'); ?></option>
                                            <option>1000</option>
                                            <option>2000</option>
                                            <option>3000</option>
                                            <option>4000</option>
                                            <option>5000</option>
                                            <option>10000</option>
                                            <option>15000</option>
                                            <option>20000</option>
                                            <option>30000</option>
                                            <option>40000</option>
                                            <option>50000</option>
                                            <option>60000</option>
                                            <option>70000</option>
                                            <option>80000</option>
                                            <option>90000</option>
                                            <option>100000</option>
                                            <option>110000</option>
                                            <option>120000</option>
                                            <option>130000</option>
                                            <option>140000</option>
                                            <option>150000</option>
                                        </select>
                                    </div>
                                    <!-- Select Input / End -->

                                </div>


                                <!-- Max Price -->
                                <div class="col-md-3">

                                    <!-- Select Input -->
                                    <div class="select-input disabled-first-option">
                                        <input type="text" placeholder="<?php echo app('translator')->getFromJson('app.max_price'); ?>" name="max_price" data-unit="ريال" value="<?php echo e(request()->get('max_price'), false); ?>">
                                        <select>
                                            <option><?php echo app('translator')->getFromJson('app.max_price'); ?></option>
                                            <option>1000</option>
                                            <option>2000</option>
                                            <option>3000</option>
                                            <option>4000</option>
                                            <option>5000</option>
                                            <option>10000</option>
                                            <option>15000</option>
                                            <option>20000</option>
                                            <option>30000</option>
                                            <option>40000</option>
                                            <option>50000</option>
                                            <option>60000</option>
                                            <option>70000</option>
                                            <option>80000</option>
                                            <option>90000</option>
                                            <option>100000</option>
                                            <option>110000</option>
                                            <option>120000</option>
                                            <option>130000</option>
                                            <option>140000</option>
                                            <option>150000</option>
                                        </select>
                                    </div>
                                    <!-- Select Input / End -->
                                </div>

                            </div>
                            <!-- Row With Forms / End -->
                            <div class="row with-forms">
                                <div class="row margin-bottom-15">
                                    <div class="col-md-6">
                                        <!-- Sort by -->
                                        <div class="sort-by">
                                            <label>ترتيب حسب:</label>
                                            <div class="sort-by-select">
                                                <select data-placeholder="Default order" name="order" class="chosen-select-no-single" id="order">
                                                    <option <?php echo e(((request()->get('order') == 'default') ? 'selected' : ''), false); ?> value="default">الترتيب الافتراضي</option>
                                                    <option <?php echo e(((request()->get('order') == 'low') ? 'selected' : ''), false); ?> value="low">السعر من الارخص للاعلى</option>
                                                    <option <?php echo e(((request()->get('order') == 'high') ? 'selected' : ''), false); ?> value="high">السعر الاعلى الى الادنى</option>
                                                    <option <?php echo e(((request()->get('order') == 'newest') ? 'selected' : ''), false); ?> value="newest">أحدث الإعلان</option>
                                                    <option <?php echo e(((request()->get('order') == 'oldest') ? 'selected' : ''), false); ?> value="oldest">أقدم إعلان</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Layout Switcher -->
                                        <h6>عدد الاعلانات : <?php echo e($ads->count(), false); ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- Box / End -->
                </div>
            </div>
        </div>
    </section>

    <!-- Content
    ================================================== -->
    <div class="container">
        <div class="row fullwidth-layout">
            <div class="col-md-12">
                <!-- Sorting / Layout Switcher -->
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            <!-- Listings -->
                <div class="listings-container list-layout">
                    <?php if($ads->count()): ?>
                        <?php $__currentLoopData = $ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="listing-item">
                                <a href="<?php echo e(route('ads.show',$ad->id), false); ?>" class="listing-img-container">
                                    <div class="listing-badges">
                                        <?php if($ad->featured ==1): ?>
                                            <span class="featured"><?php echo app('translator')->getFromJson('app.featured'); ?></span>
                                        <?php else: ?>
                                            <span></span>
                                        <?php endif; ?>
                                        <span><?php echo e($ad->category->title, false); ?></span>
                                    </div>
                                    <div class="listing-img-content">
                                        <span class="listing-price"><?php echo e(number_format($ad->price), false); ?> ريال</span>
                                        
                                        
                                    </div>
                                    <div class="listing-carousel">
                                        <?php if(isset($ad->images) && !is_null($ad->images)): ?>
                                            <?php $__currentLoopData = $ad->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div><img src="/uploads/<?php echo e($image, false); ?>" alt="<?php echo e($image, false); ?>"></div>
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
                                        <a href="<?php echo e(route('ads.show',$ad->id), false); ?>" class="details button border"><?php echo app('translator')->getFromJson('app.details'); ?></a>
                                    </div>
                                    <ul class="listing-details">
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
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <h3 style="text-align: center">
                            <?php echo app('translator')->getFromJson('app.no_ads_found'); ?>
                        </h3>
                    <?php endif; ?>
                </div>
                <!-- Listings Container / End -->
                <div class="clearfix"></div>
                <?php if($ads->count()): ?>
                    <!-- Pagination -->
                        <div class="pagination-container margin-top-20">
                        <nav class="pagination">
                            <ul>
                                <?php echo e($ads->links(), false); ?>

                            </ul>
                        </nav>
                        <nav class="pagination-next-prev">
                            <ul>
                                <li><a href="<?php echo e($ads->previousPageUrl(), false); ?>" class="prev"><?php echo app('translator')->getFromJson('app.previous'); ?></a></li>
                                <li><a href="<?php echo e($ads->nextPageUrl(), false); ?>" class="next"><?php echo app('translator')->getFromJson('app.next'); ?></a></li>
                            </ul>
                        </nav>
                    </div>
                    <!-- Pagination / End -->
                <?php endif; ?>
            </div>

        </div>
    </div>
    <!-- Footer
    ================================================== -->
    <div class="margin-top-55"></div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js_after'); ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#order').change(function (e) {
                var data = '';
                if ('<?php echo e(request()->has('ad_id'), false); ?>') {
                    data = data + 'ad_id=' + '<?php echo e(request()->ad_id, false); ?>' + '&';
                }
                if ('<?php echo e(request()->has('search'), false); ?>') {
                    data = data + 'search=' + '<?php echo e(request()->search, false); ?>' + '&';
                }
                if ('<?php echo e(request()->has('category_id'), false); ?>') {
                    data = data + 'category_id=' + '<?php echo e(request()->category_id, false); ?>' + '&';
                }
                if ('<?php echo e(request()->has('max_price'), false); ?>') {
                    data = data + 'max_price=' + '<?php echo e(request()->max_price, false); ?>' + '&';
                }
                if ('<?php echo e(request()->has('min_price'), false); ?>') {
                    data = data + 'min_price=' + '<?php echo e(request()->min_price, false); ?>' + '&';
                }
                if ('<?php echo e(request()->has('max_area'), false); ?>') {
                    data = data + 'max_area=' + '<?php echo e(request()->max_area, false); ?>' + '&';
                }
                if ('<?php echo e(request()->has('min_area'), false); ?>') {
                    data = data + 'min_area=' + '<?php echo e(request()->min_area, false); ?>' + '&';
                }
                if ('<?php echo e(request()->has('order'), false); ?>') {
                    data = data + 'order=' + '<?php echo e(request()->order, false); ?>' + '&';
                } else {
                    data = data + 'order=' + $(this).val() + '&';
                }
                console.log(data);
                window.location.href = 'ads?' + data;
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>