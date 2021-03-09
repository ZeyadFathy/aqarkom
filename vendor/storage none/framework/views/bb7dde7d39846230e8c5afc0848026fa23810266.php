<?php $__env->startSection('PageTitle','تواصل معانا'); ?>
<?php $__env->startSection('content'); ?>
    <!-- Content ================================================== -->
    <!-- Map Container -->
    <div class="contact-map margin-bottom-55">





















        <!-- Office / End -->

    </div>
    <div class="clearfix"></div>
    <!-- Map Container / End -->
    <br>
    <!-- Container / Start -->
    <div class="container">

        <div class="row">




















            <!-- Contact Form -->
            <div class="col-md-8">

                <section id="contact">
                    <h4 class="headline margin-bottom-35"><?php echo app('translator')->getFromJson('app.contactus'); ?></h4>

                    <div id="contact-message"></div>

                    <form method="post" action="<?php echo e(route('contactus.store'), false); ?>" name="contactform" id="contactform" autocomplete="on">
                        <?php echo e(csrf_field(), false); ?>

                        <div>
                            <input name="title" type="text" id="title" placeholder="<?php echo app('translator')->getFromJson('app.subject_message'); ?>" required="required"/>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div>
                                    <input name="email" type="email" id="email" placeholder="<?php echo app('translator')->getFromJson('app.e-mail'); ?>"
                                           pattern="^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$" required="required"/>
                                </div>
                            </div>
                        </div>
                        <div>
                            <textarea name="message" cols="40" rows="3" id="comments" placeholder="<?php echo app('translator')->getFromJson('app.message'); ?>" spellcheck="true" required="required"></textarea>
                        </div>
                        <input type="submit" class="submit button" id="submit" value="<?php echo app('translator')->getFromJson('app.send_message'); ?>"/>
                    </form>
                </section>
            </div>
            <!-- Contact Form / End -->

        </div>

    </div>
    <!-- Container / End -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>