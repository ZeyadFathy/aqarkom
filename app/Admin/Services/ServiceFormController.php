<?php

namespace App\Admin\Services;

use App\Admin\Services\ServiceInquiry;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ServiceFormController extends Controller
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
            ->header('طلبات الخدمات')
            ->description('عرض طلبات الخدمات')
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
            ->description('تفاصيل الطلب')
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
            ->description('تعديل بيانات الطلب')
            ->body($this->form()->edit($id));
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
            ->header('إنشاء')
            ->description('طلب خدمة جديد')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ServiceInquiry);

        $grid->id('الرقم');
        $grid->service()->title('الخدمة');
        $grid->city('المدينة');
        $grid->mobile('رقم الجوال');
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
        $show = new Show(ServiceInquiry::findOrFail($id));

        $show->id('الرقم');
        $show->service('اسم الخدمة  ')->as(function ($service) {
            return "{$service->title}";
        });
        $show->city('المدينة');
        $show->mobile('رقم الجوال');
        $show->inquiry('الاستفسار');
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
        $form = new Form(new ServiceInquiry);

        $form->select('service_id', 'الخدمة')->options(Service::pluck('title', 'id')->all())->rules('required');
        $form->text('city', 'المدينة')->rules('required');;
        $form->text('mobile', 'الجوال')->rules('required');;
        $form->text('inquiry', 'الاستفسار')->rules('required');;

        return $form;
    }
}
