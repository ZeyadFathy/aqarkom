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

class CompanyReviewController extends Controller
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
            ->header('تقيم الشركة')
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

    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {

    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CompanyReview);

        $grid->id('الرقم');
        $grid->rate('التقيم');
        $grid->comment('التعليق');
        $grid->company()->title_ar('الشركة');
        $grid->company()->title_en('الشركة');
        $grid->user()->name('المستخدم');

        $grid->status('الحالة')->radio([
            -1 => 'قيد المراجعة',
            1 => 'مقبول',
            0 => 'مرفوض',
        ]);
        $grid->created_at('تاريخ الإنشاء');
        $grid->updated_at('اخر تحديث');

        $grid->disableActions();
        $grid->disableFilter();
        $grid->disableCreateButton();


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

    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new CompanyReview);

        $form->radio('status', 'الحالة')->options(
            [
                -1 => 'قيد المراجعة',
                1 => 'مقبول',
                0 => 'مرفوض',
            ]
        )->rules('required');

        return $form;
    }
}
