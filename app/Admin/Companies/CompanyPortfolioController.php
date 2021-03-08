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

class CompanyPortfolioController extends Controller
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
            ->header('اعمال الشركات')
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
            ->header('الاعمال')
            ->description('بيانات الاعمال')
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
            ->description('تعديل الاعامال')
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
            ->header('إضافة عمل')
            ->description('عمل جديد')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CompanyPortfolio);

        $grid->id('الرقم');
        $grid->title_ar('اسم العمل عربي');
        $grid->title_en('اسم العمل انجليزي');
        $grid->company()->title_ar('القسم');
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
        $show = new Show(CompanyPortfolio::findOrFail($id));

        $show->id('الرقم');
        $show->title_ar('اسم العمل عربي');
        $show->title_en('اسم العمل انجليزي');

        $show->company('الشركة', function ($category) {

            $category->setResource('/admin/companies');

            $category->title_ar();
        });


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
        $form = new Form(new CompanyPortfolio);
        $form->text('title_ar', 'اسم العمل عربي')->rules('required');
        $form->text('title_en', 'اسم العمل انجليزي')->rules('required');
        $form->text('description_ar', 'وصف الشركة عربي')->rules('required');
        $form->text('description_en', 'وصف الشركة انجليزي')->rules('required');
        $form->select('company_id', 'الشركة')->options(Company::pluck('title_ar', 'id')->all())->rules('required');
        $form->multipleImage('images', 'الصور')->removable()->rules('required');
        return $form;
    }
}
