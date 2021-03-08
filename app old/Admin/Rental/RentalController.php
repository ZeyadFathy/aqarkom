<?php

namespace App\Admin\Rental;

use App\Admin\Rental\Rental;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class RentalController extends Controller
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
            ->header('طلبات الايجار')
            ->description('عرض الطلبات')
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
            ->header('Edit')
            ->description('description')
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
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Rental);

        $grid->id('الرقم');
        $grid->owner_id('هوية المالك');
        $grid->renter_id('هوية المستأجر');
        $grid->mobile('الجوال');
        $grid->created_at('تاريخ الانشاء');
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
        $show = new Show(Rental::findOrFail($id));

        $show->id('Id');
        $show->owner_id('هوية المالك');
        $show->renter_id('هوية المستأجر');
        $show->mobile('الجوال');
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
        $form = new Form(new Rental);

        $form->text('owner_id', 'هوية المالك');
        $form->text('renter_id', 'هوية المستأجر');
        $form->text('mobile', 'الجوال');

        return $form;
    }
}
