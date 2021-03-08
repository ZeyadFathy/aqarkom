<?php

namespace App\Admin\Services;

use App\Admin\Services\Service;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ServiceController extends Controller
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
            ->header('الخدمات')
            ->description('عرض الخدمات')
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
            ->header('تفاصيل الخدمة')
            ->description('بيانات الخدمة')
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
            ->header('تعديل الخدمة')
            ->description('تعديل البيانات')
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
            ->description('خدمة جديدة')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Service);
        $grid->id('الرقم');
        $grid->title('اسم الخدمة');
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
        $show = new Show(Service::findOrFail($id));

        $show->id('الرقم');
        $show->title('اسم الخدمة');
        $show->description('بيانات الخدمة');
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
        $form = new Form(new Service);

        $form->text('title', 'اسم الخدمة');
        $form->text('description', 'وصف الخدمة');

        return $form;
    }
}
