<?php
// Copyright

namespace App\Admin\Companies;


use App\Admin\Cities\City;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CompanyController extends Controller
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
            ->header('الشركات')
            ->description('')
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
            ->header('تفاصيل')
            ->description('بيانات الشركة')
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
            ->description('تعديل الشركة')
            ->body($this->form($id)->edit($id));
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
            ->header('إضافة شركة')
            ->description('شركة جديد')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Company);

        $grid->id('الرقم');
        $grid->title_ar('اسم الشركة عربي');
        $grid->title_en('اسم الشركة انجليزي');

        $grid->description_ar('وصف الشركة');
        $grid->contact_number('رقم التواصل');
        $grid->email('البريد الالكتروني');
        $grid->company_category()->title_ar('القسم');
        $grid->city()->title('المدينة');
        $grid->company_view('عدد المشاهدات')->count();
        $grid->status('الحالة')->radio([
            -1 => 'قيد المراجعة',
            1 => 'مقبول',
            0 => 'مرفوض',
        ]);
        $grid->featured('مميز')->editable('select', [
            1 => 'نعم',
            -1 => 'لا',
        ]);
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
        $show = new Show(Company::findOrFail($id));

        $show->id('الرقم');
        $show->title_ar('اسم الشركة عربي');
        $show->title_en('اسم الشركة انجليزي');

        $show->description_ar('وصف الشركة عربي');
        $show->description_en('وصف الشركة انجليزي');

        $show->contact_number('اسم الشركة');
        $show->email('email');
        $show->facebook('facebook');
        $show->instagram('instagram');
        $show->twitter('twitter');
        $show->website('website');
        $show->csr('csr');
        $show->image('الصورة الشخصية')->image();
        $show->company_category('القسم', function ($category) {

            $category->setResource('/admin/companies_category');

            $category->title_ar();
        });
        $show->city('المدينة', function ($category) {

            $category->setResource('/admin/cities');

            $category->title();
        });
        $show->status('الحالة')->using([-1 => 'قيد المراجعة', 1 => 'مقبول', 0 => 'مرفوض',]);
        $show->featured('حالة التميز')->using(['1' => 'مميز', '-1' => 'غير مميز']);
        $show->long('احداثي الطول');
        $show->lat('احداثي العرض');

        $show->created_at('تاريخ الإنشاء');
        $show->updated_at('اخر تحديث');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @param null $id
     * @return Form
     */
    protected function form($id = null)
    {
        if (isset($id)) {
            $compnay = Company::find($id);
            $days = json_decode($compnay->days, true);
            $days_en = json_decode($compnay->days_en, true);
        }
        $form = new Form(new Company);
        $form->hidden('days');
        $form->hidden('days_en');
        $form->text('title_ar', 'اسم الشركة عربي')->rules('required');
        $form->text('title_en', 'اسم الشركة انجليزي')->rules('required');
        $form->textarea('description_ar', 'التفاصيل عربي')->rules('required');
        $form->textarea('description_en', 'التفاصيل انجليزي')->rules('required');
        $form->text('contact_number', 'رقم التواصل')->rules('required');
        $form->text('email', 'البريد الالكتروني')->rules('required');
        $form->text('facebook', 'facebook');
        $form->text('instagram', 'instagram');
        $form->text('twitter', 'twitter');
        $form->text('website', 'website');
        $form->text('csr', 'رقم السجل')->rules(['max:15', 'required']);
        $form->select('city_id', 'المدينة')->options(City::pluck('title', 'id')->all())->rules('required');
        $form->select('category_id', 'القسم')->options(CompanyCategory::pluck('title_ar', 'id')->all())->rules('required');
        $form->radio('status', 'الحالة')->options(
            [
                -1 => 'قيد المراجعة',
                1 => 'مقبول',
                0 => 'مرفوض',
            ]
        )->rules('required');
        $form->radio('featured', 'مميز')->options(
            [
                1 => 'نعم',
                -1 => 'لا',
            ]
        )->rules('required');
        $form->map('lat', 'long', 'الخريطة')->useGoogleMap();
        $form->text('location', 'الموقع الجغرافي');
        $form->image('image', 'image');

        $form->radio('saturday', 'السبت')->options([1 => 'يوم عمل', 0 => 'عطله'])->default(isset($days['saturday']));
        $form->text('sat', 'موعيد العميل ليوم السبت')->rules(['max:40'])->default($days['saturday'] ?? null);
        $form->text('sat_en', 'موعيد العميل ليوم السبت - انجليزي')->rules(['max:40'])->default($days_en['saturday'] ?? null);

        $form->radio('sunday', 'الاحد')->options([1 => 'يوم عمل', 0 => 'عطله'])->default(isset($days['sunday']));
        $form->text('sun', 'موعيد العميل ليوم الاحد')->rules(['max:40'])->default($days['sunday'] ?? null);
        $form->text('sun_en', 'موعيد العميل ليوم الاحد - انجليزي')->rules(['max:40'])->default($days_en['sunday'] ?? null);

        $form->radio('monday', 'الاثنين')->options([1 => 'يوم عمل', 0 => 'عطله'])->default(isset($days['monday']));
        $form->text('mon', 'موعيد العميل ليوم الاثنين')->rules(['max:40'])->default($days['monday'] ?? null);
        $form->text('mon_en', 'موعيد العميل ليوم الاثنين - انجليزي')->rules(['max:40'])->default($days_en['monday'] ?? null);

        $form->radio('tuesday', 'الثلاثاء')->options([1 => 'يوم عمل', 0 => 'عطله'])->default(isset($days['tuesday']));
        $form->text('tues', 'موعيد العميل ليوم الثلاثاء')->rules(['max:40'])->default($days['tuesday'] ?? null);
        $form->text('tues_en', 'موعيد العميل ليوم الثلاثاء - انجليزي')->rules(['max:40'])->default($days_en['tuesday'] ?? null);

        $form->radio('wednesday', 'الاربعاء')->options([1 => 'يوم عمل', 0 => 'عطله'])->default(isset($days['wednesday']));
        $form->text('wed', 'موعيد العميل ليوم الاربعاء')->rules(['max:40'])->default($days['wednesday'] ?? null);
        $form->text('wed_en', 'موعيد العميل ليوم الاربعاء - انجليزي')->rules(['max:40'])->default($days_en['wednesday'] ?? null);

        $form->radio('thursday', 'الخميس')->options([1 => 'يوم عمل', 0 => 'عطله'])->default(isset($days['thursday']));
        $form->text('thurs', 'موعيد العميل ليوم الخميس')->rules(['max:40'])->default($days['thursday'] ?? null);
        $form->text('thurs_en', 'موعيد العميل ليوم الخميس - انجليزي')->rules(['max:40'])->default($days_en['thursday'] ?? null);

        $form->radio('friday', 'الجمعه')->options([1 => 'يوم عمل', 0 => 'عطله'])->default(isset($days['friday']));
        $form->text('fri', 'موعيد العميل ليوم الجمعه')->rules(['max:40'])->default($days['friday'] ?? null);
        $form->text('fri_en', 'موعيد العميل ليوم الجمعه - انجليزي')->rules(['max:40'])->default($days_en['friday'] ?? null);


        return $form;
    }

    public function store()
    {
        $this->setDays();
        return $this->form()->store();
    }

    public function update($id)
    {
        $this->setDays();

        return $this->form()->update($id);
    }

    public function setDays()
    {
        $days = [];
        $days_en = [];

        if (request()->request->get('saturday') && !is_null(request()->request->get('sat'))) {
            $days += ['saturday' => request()->request->get('sat')];
            $days_en += ['saturday' => request()->request->get('sat_en')];
        }
        if (request()->request->get('sunday') && !is_null(request()->request->get('sun'))) {
            $days += ['sunday' => request()->request->get('sun')];
            $days_en += ['sunday' => request()->request->get('sun_en')];
        }
        if (request()->request->get('monday') && !is_null(request()->request->get('mon'))) {
            $days += ['monday' => request()->request->get('mon')];
            $days_en += ['monday' => request()->request->get('mon_en')];
        }
        if (request()->request->get('tuesday') && !is_null(request()->request->get('tues'))) {
            $days += ['tuesday' => request()->request->get('tues')];
            $days_en += ['tuesday' => request()->request->get('tues_en')];
        }
        if (request()->request->get('wednesday') && !is_null(request()->request->get('wed'))) {
            $days += ['wednesday' => request()->request->get('wed')];
            $days_en += ['wednesday' => request()->request->get('wed_en')];
        }
        if (request()->request->get('thursday') && !is_null(request()->request->get('thurs'))) {
            $days += ['thursday' => request()->request->get('thurs')];
            $days_en += ['thursday' => request()->request->get('thurs_en')];
        }
        if (request()->request->get('friday') && !is_null(request()->request->get('fri'))) {
            $days += ['friday' => request()->request->get('fri')];
            $days_en += ['friday' => request()->request->get('fri_en')];
        }

        request()->request->remove('saturday');
        request()->request->remove('sat');
        request()->request->remove('sat_en');
        request()->request->remove('sunday');
        request()->request->remove('sun_en');
        request()->request->remove('sun');
        request()->request->remove('monday');
        request()->request->remove('mon');
        request()->request->remove('mon_en');
        request()->request->remove('tuesday');
        request()->request->remove('tues');
        request()->request->remove('tues_en');
        request()->request->remove('wednesday');
        request()->request->remove('wed');
        request()->request->remove('wed_en');
        request()->request->remove('thursday');
        request()->request->remove('thurs');
        request()->request->remove('thurs_en');
        request()->request->remove('friday');
        request()->request->remove('fri');
        request()->request->remove('fri_en');

        request()->request->set('days', json_encode($days));
        request()->request->set('days_en', json_encode($days_en));
    }

}
