<!DOCTYPE html>
<html>
<head>
    <!-- Basic Page Needs
================================================== -->
    <title>تسجيل شركائنا | Aqarito</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- CSS
    ================================================== -->
    <meta property="og:title" content="تسجيل شركائنا">
    <meta property="og:image" content="http://old-api.aqarito.net/uploads/logo-background.jpg">
    <meta property="og:description" content="تطبيق عقاريتو متوفر على أجهزة الآبل والأندرويد، متنوع الخدمات، وقد تم تصميمه لاستخدامه بسهولة وتميز يُسهل على العميل الوصول إلى الخدمة دون أدنى جهد،
حيث أن تطبيق عقاريتو يعد من التطبيقات الأولى والرائدة في مجال تقديم جميع الخدمات العقارية بالمملكة العربية السعودية ودول مجلس التعاون لدول الخليج العربي وجمهورية مصر والمملكة الأردنية قريباً


ما يميز تطبيق عقاريتو؟
صمّم تطبيق عقاريتو خصيصا لإرضاء المستخدمين، إذا كنت تبحث عن تصاميم داخلية، استشارات هندسية، بناء ومقاولات، صيانة وتشغيل، تصاميم معمارية متميزة، مواد بناء، ويسهل عليك عناء البحث في الوصول الى مقدمي خدمات القروض العقارية من بنوك وشركات التمويل العقاري وتأمين المباني عن طريق شركات التأمين،  نترك لك خيار اكتشاف خدمات عقاريتو العقارية، تجدون على تطبيق عقاريتو واجهة خاصة لوضع مختلف عروضكم العقارية وكذلك عنوانها وصورها والأسعار المتاحة لها، كما يسهل على المستخدمين التواصل مع بعضهم من خلال عقاريتو، استفد إذا بكل خدمات تطبيق عقاريتو باعتباره رائدا في تقديم جميع ما يتعلق بالخدمات العقارية واكثر التطبيقات بحثا وسعيا لإرضاء المستخدمين


رؤية عقاريتو 2030
 يسعى عقاريتو دوما إلى بلوغ الريادة وتحقيق التميز والتنوع في الخدمات العقارية مواكبا مع كل التطورات والتطلعات التي تهدف المملكة العربية السعودية إلى بلوغها في مجالات جميع الخدمات العقارية، ولهذا يمكن اعتبار عقاريتو التطبيق الأمثل والأفضل من دون منازع في مجال العقار على مستوى بالمملكة العربية السعودية ودول مجلس التعاون لدول الخليج العربي وجمهورية مصر العربية والمملكة الأردنية الهاشمية، حيث ان تطبيق عقاريتو هدفه الأول المحافظة الدائمة على الريادة.

About Aqarito:
Aqarito application is available in apple and android, multi-services, it was designed to be easily used by the client and without any efforts.
Aqarito is considered among the first and the leading applications in providing multi-services field in the United Kingdom of Arabi Saudi, Gulf cooperation council states, the Arab republic of Egypt and the Hashemite Kingdom of Jordan.

What makes Aqarito special?
Aqarito was designed specially to make the users satisfied , You are looking for interior designs , engineering consulting , constructions , maintenance and operations , special architectural designs , building materials , it makes it easier for you to access mortgage loans providers from banks and mortgage financing companies .
We let you discover Aqarito real estate services.
In Aqarito application, you find a page where you can share your real estate offers with the title, pictures and the prices .
Aqarito gives you the opportunity to communicate with other users, get the most services out of Aqarito since it is considered the leader of all what is related to real estate services, and the application which always seeks to make its users satisfied.

Aqarito’s vision on 2030:
Aqrito always seeks on being the leader, achieving excellence and the diversity in real estate services keeping up with all the developments that the United Kingdom of Arabi Saudi tends to reach in all fields of real estate services.
That’s why Aqarito can be considered as the best application in its field in the United Kingdom of arabi Saudi, gulf cooperation council states, the Arab republic of Egypt and the Hashemite kingdom of Jordan, whereas Aqarito’s first goal is to be on the lead.">

    <link rel="stylesheet" href="http://old-api.aqarito.net/frontend/css/style.css">
    <link rel="stylesheet" href="http://old-api.aqarito.net/frontend/css/colors/green.css" id="colors">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/earlyaccess/droidarabickufi.css" />
    <link rel="stylesheet" href="http://old-api.aqarito.net/frontend/css/stylePartner.css">
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-150731558-1"></script>
    <script type="application/javascript">
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-150731558-1');
    </script>
</head>
<body>
<section class="partner" style="direction:rtl">
    <div class="overlay">
        <div class="container">
            <nav>
                <img src="http://old-api.aqarito.net/images/logoaq.png">
                <a href="#"><button>الرئيسية</button></a>
            </nav>
            <div class="row">
                <div class="col-md-12">
                    <!-- Title -->
                    <h3 class="search-title">تسجيل شركائنا</h3>
                    <?php if(session('success')): ?>
                    <div class="alert alert-success"><?php echo e(session('success'), false); ?></div>
                    <?php endif; ?>
                    <?php if($errors->any()): ?>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="alert alert-danger"><?php echo e($error, false); ?></div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    <!-- Form -->
                    <!-- Main Search -->
                    <form method="post" action="<?php echo e(route('companies.store'), false); ?>" autocomplete="off" enctype="multipart/form-data">
                        <?php echo e(csrf_field(), false); ?>

                        <div class="main-search-box no-shadow">
                            <!-- Row With Forms -->
                            <div class="row with-forms">
                                <div class="col-md-6">
                                    <div class="main-search-input">
                                        <input type="text" id="title_ar" name="title_ar" placeholder="إسم الشركة بالعربية" value="<?php echo e(request()->get('title_ar'), false); ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="main-search-input">
                                        <input type="text" id="title_en" name="title_en" placeholder="إسم الشركة بالانجليزية" value="<?php echo e(request()->get('title_en'), false); ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="main-search-input">
                                        <textarea id="description_ar" name="description_ar" placeholder="وصف الشركة بالعربية"><?php echo e(request()->get('description_ar'), false); ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="main-search-input">
                                        <textarea id="description_en" name="description_en" placeholder="وصف الشركة بالانجليزية"><?php echo e(request()->get('description_en'), false); ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <select data-placeholder="التصنيف" class="chosen-select-no-single" name="category_id" id="category_id">
                                        <option value="">التصنيف</option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id, false); ?>"><?php echo e($category->title_ar, false); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select data-placeholder="المدينة" class="chosen-select-no-single" name="city_id" id="city_id">
                                        <option value="">المدينة</option>
                                        <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($city->id, false); ?>"><?php echo e($city->title, false); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="main-search-input">
                                        <input type="text" id="contact_number" name="contact_number" placeholder="تليفون التواصل" value="<?php echo e(request()->get('contact_number'), false); ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="main-search-input">
                                        <input type="email" id="email" name="email" placeholder="البريد الالكترونى" value="<?php echo e(request()->get('email'), false); ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="main-search-input">
                                        <input type="url" id="facebook" name="facebook" placeholder="رابط الفيس بوك" value="<?php echo e(request()->get('facebook'), false); ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="main-search-input">
                                        <input type="url" id="instagram" name="instagram" placeholder="رابط الانستجرام" value="<?php echo e(request()->get('instagram'), false); ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="main-search-input">
                                        <input type="url" id="twitter" name="twitter" placeholder="رابط تويتر" value="<?php echo e(request()->get('twitter'), false); ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="main-search-input">
                                        <input type="url" id="website" name="website" placeholder="رابط الموقع الالكترونى" value="<?php echo e(request()->get('website'), false); ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="main-search-input">
                                        <input type="file" id="image" name="image" placeholder="شعار الشركة" value="<?php echo e(request()->get('image'), false); ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="main-search-input">
                                        <input type="text" id="csr" name="csr" placeholder="السجل التجارى" value="<?php echo e(request()->get('csr'), false); ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="main-search-input">
                                        <input type="text" id="long" name="long" placeholder="احداثى الشركة ( خط طول )" value="<?php echo e(request()->get('long'), false); ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="main-search-input">
                                        <input type="text" id="lat" name="lat" placeholder="احداثى الشركة ( دائرة عرض )" value="<?php echo e(request()->get('lat'), false); ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-6 working-day">
                                    <h4>مواقيت العمل</h4>
                                    <div class="main-search-input" style="display: block">
                                        <div class="row">
                                            <div class="col-sm-2 day">
                                                <input type="checkbox" id="day_0" name="day[]" value="0" style="height: 20px; width: 20px;vertical-align: sub;"/>
                                                <label for="day_0" style="display: inline-block">الاحد</label>
                                            </div>
                                            <div class="col-sm-5">
                                                <label for="from_0">من</label>
                                                <input type="time" id="from_0" name="from_0" title="from" value="<?php echo e(request()->get('from_0'), false); ?>"/>
                                            </div>
                                            <div class="col-sm-5">
                                                <label for="to_0">الى</label>
                                                <input type="time" id="to_0" name="to_0" title="to" value="<?php echo e(request()->get('to_0'), false); ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="main-search-input" style="display: block">
                                        <div class="row">
                                            <div class="col-sm-2 day">
                                                <input type="checkbox" id="day_1" name="day[]" value="1" style="height: 20px; width: 20px;vertical-align: sub;"/>
                                                <label for="day_1" style="display: inline-block">الاثنين</label>
                                            </div>
                                            <div class="col-sm-5">
                                                <label for="from_1">من</label>
                                                <input type="time" id="from_1" name="from_1" title="from" value="<?php echo e(request()->get('from_1'), false); ?>"/>
                                            </div>
                                            <div class="col-sm-5">
                                                <label for="to_1">الى</label>
                                                <input type="time" id="to_1" name="to_1" title="to" value="<?php echo e(request()->get('to_1'), false); ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="main-search-input" style="display: block">
                                        <div class="row">
                                            <div class="col-sm-2 day">
                                                <input type="checkbox" id="day_2" name="day[]" value="2" style="height: 20px; width: 20px;vertical-align: sub;"/>
                                                <label for="day_2" style="display: inline-block">الثلاثاء</label>
                                            </div>
                                            <div class="col-sm-5">
                                                <label for="from_2">من</label>
                                                <input type="time" id="from_2" name="from_2" title="from" value="<?php echo e(request()->get('from_2'), false); ?>"/>
                                            </div>
                                            <div class="col-sm-5">
                                                <label for="to_2">الى</label>
                                                <input type="time" id="to_2" name="to_2" title="to" value="<?php echo e(request()->get('to_2'), false); ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="main-search-input" style="display: block">
                                        <div class="row">
                                            <div class="col-sm-2 day">
                                                <input type="checkbox" id="day_3" name="day[]" value="3" style="height: 20px; width: 20px;vertical-align: sub;"/>
                                                <label for="day_3" style="display: inline-block">الاربعاء</label>
                                            </div>
                                            <div class="col-sm-5">
                                                <label for="from_3">من</label>
                                                <input type="time" id="from_3" name="from_3" title="from" value="<?php echo e(request()->get('from_3'), false); ?>"/>
                                            </div>
                                            <div class="col-sm-5">
                                                <label for="to_3">الى</label>
                                                <input type="time" id="to_3" name="to_3" title="to" value="<?php echo e(request()->get('to_3'), false); ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="main-search-input" style="display: block">
                                        <div class="row">
                                            <div class="col-sm-2 day">
                                                <input type="checkbox" id="day_4" name="day[]" value="4" style="height: 20px; width: 20px;vertical-align: sub;"/>
                                                <label for="day_4" style="display: inline-block">الخميس</label>
                                            </div>
                                            <div class="col-sm-5">
                                                <label for="from_4">من</label>
                                                <input type="time" id="from_4" name="from_4" title="from" value="<?php echo e(request()->get('from_4'), false); ?>"/>
                                            </div>
                                            <div class="col-sm-5">
                                                <label for="to_4">الى</label>
                                                <input type="time" id="to_4" name="to_4" title="to" value="<?php echo e(request()->get('to_4'), false); ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="main-search-input" style="display: block">
                                        <div class="row">
                                            <div class="col-sm-2 day">
                                                <input type="checkbox" id="day_5" name="day[]" value="5" style="height: 20px; width: 20px;vertical-align: sub;"/>
                                                <label for="day_5" style="display: inline-block">الجمعة</label>
                                            </div>
                                            <div class="col-sm-5">
                                                <label for="from_5">من</label>
                                                <input type="time" id="from_5" name="from_5" title="from" value="<?php echo e(request()->get('from_5'), false); ?>"/>
                                            </div>
                                            <div class="col-sm-5">
                                                <label for="to_5">الى</label>
                                                <input type="time" id="to_5" name="to_5" title="to" value="<?php echo e(request()->get('to_5'), false); ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="main-search-input" style="display: block">
                                        <div class="row">
                                            <div class="col-sm-2 day">
                                                <input type="checkbox" id="day_6" name="day[]" value="6" style="height: 20px; width: 20px;vertical-align: sub;"/>
                                                <label for="day_6" style="display: inline-block">السبت</label>
                                            </div>
                                            <div class="col-sm-5">
                                                <label for="from_6">من</label>
                                                <input type="time" id="from_6" name="from_6" title="from" value="<?php echo e(request()->get('from_6'), false); ?>"/>
                                            </div>
                                            <div class="col-sm-5">
                                                <label for="to_6">الى</label>
                                                <input type="time" id="to_6" name="to_6" title="to" value="<?php echo e(request()->get('to_6'), false); ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Main Search Input -->
                                <div class="col-md-12">
                                    <div class="main-search-input">
                                        <button type="submit" class="button" style="margin-right: 0">تسجيل</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- Box / End -->
                </div>
            </div>
        </div>
    </div>
</section>
<section class="details">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3>التعريف الاول</h3>
                <p>عندما يريد العالم أن ‪يتكلّم ‬ ، فهو يتحدّث بلغة يونيكود. تسجّل الآن لحضور المؤتمر الدولي العاشر ليونيكود (Unicode Conference)، الذي سيعقد في 10-12 آذار 1997 بمدينة مَايِنْتْس، ألمانيا. و سيجمع المؤتمر بين خبراء من كافة قطاعات الصناعة على الشبكة العالمية انترنيت ويونيكود، حيث ستتم، على الصعيدين الدولي والمحلي على حد سواء مناقشة سبل استخدام يونكود في النظم القائمة وفيما يخص التطبيقات الحاسوبية، الخطوط، تصميم النصوص والحوسبة متعددة اللغات.</p>
            </div>
            <div class="col-md-6">
                <h3>التعريف الاول</h3>
                <p>عندما يريد العالم أن ‪يتكلّم ‬ ، فهو يتحدّث بلغة يونيكود. تسجّل الآن لحضور المؤتمر الدولي العاشر ليونيكود (Unicode Conference)، الذي سيعقد في 10-12 آذار 1997 بمدينة مَايِنْتْس، ألمانيا. و سيجمع المؤتمر بين خبراء من كافة قطاعات الصناعة على الشبكة العالمية انترنيت ويونيكود، حيث ستتم، على الصعيدين الدولي والمحلي على حد سواء مناقشة سبل استخدام يونكود في النظم القائمة وفيما يخص التطبيقات الحاسوبية، الخطوط، تصميم النصوص والحوسبة متعددة اللغات.</p>
            </div>
            <div class="col-md-6">
                <h3>التعريف الاول</h3>
                <p>عندما يريد العالم أن ‪يتكلّم ‬ ، فهو يتحدّث بلغة يونيكود. تسجّل الآن لحضور المؤتمر الدولي العاشر ليونيكود (Unicode Conference)، الذي سيعقد في 10-12 آذار 1997 بمدينة مَايِنْتْس، ألمانيا. و سيجمع المؤتمر بين خبراء من كافة قطاعات الصناعة على الشبكة العالمية انترنيت ويونيكود، حيث ستتم، على الصعيدين الدولي والمحلي على حد سواء مناقشة سبل استخدام يونكود في النظم القائمة وفيما يخص التطبيقات الحاسوبية، الخطوط، تصميم النصوص والحوسبة متعددة اللغات.</p>
            </div>
        </div>
    </div>
</section>
<footer>
    <p>جميع الحقوق محفوظه © 2020</p>
</footer>
</body>
</html>
