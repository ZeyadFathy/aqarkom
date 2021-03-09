<?php $__env->startSection('PageTitle', trans('app.policy') ); ?>
<?php $__env->startSection('content'); ?>
    <!-- Titlebar
================================================== -->
    <div id="titlebar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>سياسة الاسترجاع ورد المدفوعات</h2>
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
                    <h4>العمولات والاشتراك السنوي:</h4>
                    <p>يحق للمستخدم طلب استرجاع العمولة المدفوعة خلال (10) أيام من تاريخ الدفع، ويستثنى من ذلك استرجاع مبلغ الاشتراك السنوي.</p>
                    <h4>نقل الاشتراك:</h4>
                    <p>المدة المسموحة لنقل الاشتراك لعضو آخر مدة أقصاها (٥) أيام من تاريخ الدفع.</p>
                    <h4>المبالغ الزائدة:</h4>
                    <p>يتم استرجاع المبالغ الزائدة عن الاشتراك والعمولة خلال مدة أقصاها (٥) أيام من تاريخ الدفع</p>
                    <h4>طريقة طلب الاسترجاع</h4>
                    <ul>
                        <li>لطلب الاسترجاع يجب التواصل مع الدعم الفني من خلال "تواصل معنا" وتزويدهم بتاريخ الحوالة، البنك المحول عليه، رقم الحساب.</li>
                        <li>تستغرق مدة استرجاع المبلغ إلى حسابك مدة أقصاها (٥) أيام عمل، وفي حال أي تأخير في إعادة المبلغ يتوجب على المستخدم المتابعة مع البنك مباشرة.</li>
                        <li>في حال التحويل من بنك لبنك آخر يتم خصم رسوم البنك.</li>
                    </ul>
                </blockquote>
            </div>
        </div>
    </div>
    <div class="margin-top-55"></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>