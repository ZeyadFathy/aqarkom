<?php

namespace App\Admin\Reports;

use App\Admin\Reports\Report;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\admin\Users\User;
use App\Admin\Advertisements\Advertisement;

class ReportController extends Controller
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
            ->header('التبليغات')
            ->description('عرض التبليغات')
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
            ->header('تفاصيل التبليغ')
            ->description('التبليغ')
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
            ->header('تعديل التبليغ')
            ->description('تعديل')
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
            ->header('تبليغ جديد')
            ->description('تبليغ جديد')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Report);

        $grid->id('الرقم');
        $grid->user()->name('صاحب التبليغ');
        $grid->reason('السبب');
        $grid->ad_id('رقم الاعلان')->display(function ($ad_id) {
            return "<a href='advertisements/".$ad_id."'> <span>$ad_id</span> </a>";
        });
        $grid->created_at('تاريخ اللإنشاء');
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
        $show = new Show(Report::findOrFail($id));

        $show->id('الرقم');
        $show->ad_id('رقم الإعلان');
        $show->reason('سبب البلاغ');
        $show->created_at('تاريخ الانشاء');
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
        $form = new Form(new Report);

        $form->select('user_id', 'المستخدم')->options(User::pluck('name', 'id')->all())->rules('required');
        $form->select('ad_id', 'الاعلان')->options(Advertisement::pluck('title', 'id')->all())->rules('required');
        $form->text('reason', 'سبب البلاغ');
        return $form;
    }
}
