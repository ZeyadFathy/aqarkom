<?php

namespace App\Admin\Advertisements;

use App\Admin\Advertisements\Advertisement;
use App\Admin\Categories\Category;
use App\Admin\Notifications\PushNotifications;
use App\Admin\Users\User;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Admin\Advertisements\AdsData;
use Cocur\Slugify\Slugify;
use App\Admin\Cities\City;
class AdvertisementController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('الاعلانات')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('التفاصيل')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('تعديل')
            ->body($this->form()->edit($id))
            ->row(Admin::grid(AdsData::class, function (Grid $grid) use ($id) {
                $grid->setName('AdsData')
                    ->setTitle('الخيارات')
                    ->setRelation(Advertisement::find($id)->addata())
                    ->resource('/../admin/adsdata');
                $grid->adfilter()->title('المواصفات');
                $grid->adoption()->title('الخيار');
                $grid->text('محتوي');
            }))
            ->row(Admin::grid(AdsTextData::class, function (Grid $grid) use ($id) {
                $grid->setName('AdsTextData')
                    ->setTitle('الخيارات النصية')
                    ->setRelation(Advertisement::find($id)->adtextdata())
                    ->resource('/../admin/adstextdata');
                $grid->adfilter()->title('المواصفات');
                $grid->text('محتوي');
            }));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('إضافة اعلان')
            ->description('اعلان جديد')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Advertisement);

        $grid->id('الرقم');
        $grid->title('العنوان');
        $grid->ad_views()->views('المشاهدات');
        // $grid->user('المستخدم')->display(function ($user) {
        //     return "<span class='label label-success'>{$user['name']}</span>";
        // });
        $grid->category('القسم')->display(function ($category) {
            return "<span class='label label-success'>{$category['title_ar']}</span>";
        });
        $grid->status('الحالة')->radio([
            -1 => 'قيد المراجعة',
            1 => 'مقبول',
            0 => 'مرفوض',
        ]);
        $grid->type('النوع')->radio([
            'sell' => 'بيع',
            'rental' => 'إيجار',
        ]);
        $grid->featured('مميز')->editable('select', [
            1 => 'نعم',
            -1 => 'لا',
        ]);
        // $grid->column('position')->openMap(function () {

        //     return [$this->lat, $this->long];

        // }, 'Position');
        $grid->area('المساحة');
        $grid->price('السعر');
        $grid->created_at('تاريخ الإنشاء');
        $grid->updated_at('اخر تحديث');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Advertisement::findOrFail($id));

        $show->id('رقم الإعلان');
        $show->title('العنوان');
        $show->details('التفاصيل');
        $show->user('معلومات المستخدم', function ($user) {

            $user->setResource('/admin/users');
            $user->name('الاسم');
            $user->email('البريد الإلكتروني');
            $user->mobile('رقم الجوال');
        });
        $show->category('القسم', function ($category) {

            $category->setResource('/admin/categories');

            $category->title_ar();
        });
        // $show->images('Images');
        $show->status('الحالة')->using([-1 => 'قيد المراجعة', 1 => 'مقبول', 0 => 'مرفوض', ]);
        $show->featured('حالة التميز')->using(['1' => 'مميز', '-1' => 'غير مميز']);
        $show->type('النوع')->using(
            [
                'sell' => 'بيع',
            'rental' => 'إيجار',
            ]
        )->rules('required');
        $show->price('السعر');
        $show->area('المساحة');
        // $show->map('lat','long','الخريطة');
        $show->ad_long('احداثي الطول');
        $show->ad_lat('احداثي العرض');
        $show->location('الموقع الجغرافي');
        $show->created_at('تاريخ الإنشاء');
        $show->updated_at('اخر تحديث');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Advertisement);

        $form->text('title', 'العنوان')->rules('required');
        $form->text('slug')->disable();
        $form->textarea('details', 'التفاصيل')->rules('required');
        $form->select('user_id', 'المستخدم')->options(User::pluck('mobile', 'id')->all())->rules('required');
        $form->select('category_id', 'القسم')->options(Category::pluck('title_ar', 'id')->all())->rules('required');
        // $form->select('city_id', 'المدينة')->options(City::pluck('title', 'id')->all())->rules('required');
        $form->multipleImage('images', 'الصور')->removable();
        $form->radio('status', 'الحالة')->options(
            [
                -1 => 'قيد المراجعة',
                1 => 'مقبول',
                0 => 'مرفوض',
            ]
        )->rules('required');
        $form->radio('type', 'النوع')->options(
            [
                'sell' => 'بيع',
            'rental' => 'إيجار',
            ]
        )->rules('required');
        $form->radio('featured', 'مميز')->options(
            [
                1 => 'نعم',
                -1 => 'لا',
            ]
        )->rules('required');
        
        $form->number('area', 'المساحة')->rules('required');
        $form->currency('price', 'السعر')->symbol('ر.س')->rules('required');
        $form->map('ad_lat', 'ad_long', 'الخريطة')->useGoogleMap();
        $form->text('location', 'الموقع الجغرافي');
        return $form;
    }

    public function update($id)
    {
        $slug = $this->SlugMe(Advertisement::find($id)->title);
        if (Advertisement::where('slug', $slug)->where('id', '!=', $id)->count() > 0) {
            $int = 1;
            $slug = $this->SlugMe(request()->get('title').$int);
            while (Advertisement::where('slug', $slug)->count() > 0) {
                $int = $int + 1;
                $slug = $this->SlugMe(request()->get('title').$int);
            }
        }

        if (request('status')) {
            $ad = Advertisement::find($id);
            if(request('status') == 1)
            {
                $message =  $ad->title."تم قبول اعلانك";
            }
            elseif(request('status') == 0){
                $message = $ad->title."تم رفض اعلانك";

            }
            elseif(request('status') == -1){
                $message = $ad->title."اعلانك قيد المراجعة";

            }
            PushNotifications::sendMessage(
                $message,
                [$ad->user->device_token]
            );
        }
        request()->request->set('slug', $slug);
        return $this->form()->update($id);
    }

    public function store()
    {
        $slug = $this->SlugMe(request()->get('title'));
        if (Advertisement::where('slug', $slug)->count() > 0) {
            $int = 1;
            $slug = $this->SlugMe(request()->get('title').$int);
            while (Advertisement::where('slug', $slug)->count() > 0) {
                $int = $int + 1;
                $slug = $this->SlugMe(request()->get('title').$int);
            }
        }
        request()->request->set('slug', $slug);
        return $this->form()->store();
    }


    public static function SlugMe($string)
    {
        if (!is_null($string)) {
            $slug = new Slugify(['regexp' => '/([^\p{Arabic}a-zA-Z0-9]+|-+)/u']);
            $slug->addRules(array(
                'أ' => 'أ',
                'ب' => 'ب',
                'ت' => 'ت',
                'ث' => 'ث',
                'ج' => 'ج',
                'ح' => 'ح',
                'خ' => 'خ',
                'د' => 'د',
                'ذ' => 'ذ',
                'ر' => 'ر',
                'ز' => 'ز',
                'س' => 'س',
                'ش' => 'ش',
                'ص' => 'ص',
                'ض' => 'ض',
                'ط' => 'ط',
                'ظ' => 'ظ',
                'ع' => 'ع',
                'غ' => 'غ',
                'ف' => 'ف',
                'ق' => 'ق',
                'ك' => 'ك',
                'ل' => 'ل',
                'م' => 'م',
                'ن' => 'ن',
                'ه' => 'ه',
                'و' => 'و',
                'ي' => 'ي',
            ));
            return $slug->slugify($string);
        }
    }

}
