<?php
// Copyright

namespace App\Admin\Companies;


use App\Admin\Categories\Category;
use App\Admin\Cities\City;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CompanyCategoryController extends Controller
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
            ->header('اقسام الشركات')
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
            ->description('بيانات اقسام الشركات')
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
            ->description('تعديل اقسام الشركات')
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
            ->header('إضافة قسم')
            ->description('قسم جديد')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CompanyCategory);

        $grid->id('الرقم');
        $grid->title_ar('اسم القسم عربي');
        $grid->title_en('اسم القسم انجليزي');
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
        $show = new Show(CompanyCategory::findOrFail($id));

        $show->id('الرقم');
        $show->title_ar('اسم القسم عربي');
        $show->title_en('اسم القسم انجليزي');
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
        $form = new Form(new CompanyCategory);

        $form->text('title_ar', 'اسم القسم عربي');
        $form->text('title_en', 'اسم القسم انجليزي');

        return $form;
    }
}
