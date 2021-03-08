<?php

namespace App\Admin\Categories;

use App\Admin\Categories\Category;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CategoryController extends Controller
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
            ->header('الأقسام')
            ->description('أقسام الإعلانات')
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
            ->description('تفاصيل القسم')
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
            ->description('تعديل القسم')
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
        $grid = new Grid(new Category);

        $grid->id('الرقم');
        $grid->title_ar('اسم القسم عربي');
        $grid->title_en('اسم القسم انجليزي');
        $grid->property_type('النوع')->radio([
            1 => 'سكنى',
            2 => 'تجارى',
            -1 => 'كلاهما',
        ]);
        $grid->property_for('العقار للـ')->radio([
            1 => 'بيع',
            2 => 'إيجار',
            -1 => 'كلاهما',
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
        $show = new Show(Category::findOrFail($id));

        $show->id('الرقم');
        $show->title_ar('اسم القسم عربي');
        $show->title_en('اسم القسم انجليزي');
        $show->icon('أيقونة')->file();
        $show->property_type('النوع')->using([
            1 => 'سكنى',
            2 => 'تجارى',
            -1 => 'كلاهما',
        ]);
        $show->property_for('العقار للـ')->using([
            1 => 'بيع',
            2 => 'إيجار',
            -1 => 'كلاهما',
        ]);
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
        $form = new Form(new Category);

        $form->text('title_ar', 'اسم القسم عربي');
        $form->text('title_en', 'اسم القسم انجليزي');
        $form->file('icon', 'أيقونة');
        $form->radio('property_type', 'النوع')->options(
            [
                1 => 'سكنى',
                2 => 'تجارى',
                -1 => 'كلاهما',
            ]
        )->rules('required');
        $form->radio('property_for', 'العقار للـ')->options(
            [
                1 => 'بيع',
                2 => 'إيجار',
                -1 => 'كلاهما',
            ]
        )->rules('required');

        return $form;
    }
}
