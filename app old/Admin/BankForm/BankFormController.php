<?php

namespace App\Admin\BankForm;

use App\Admin\Users\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Show;

class BankFormController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('التحويلات البنكية');
            $content->description('التحويلات البنكية');
            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('الحسابات البنكية');

            $content->body($this->form()->edit($id));
        });
    }

    public function show($id, Content $content)
    {
        return $content
            ->header('تفاصيل')
            ->description('تفاصيل التحويل البنكي')
            ->body($this->detail($id));
    }
    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('الحسابات البنكية');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(BankForm::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->user('المستخدم')->display(function ($user) {
                return "<span class='label label-success'>{$user['name']}</span>";
            });
            $grid->name('اسم المرسل');
            $grid->amount('المبلغ');
            $grid->date('تاريخ التحويل');
            $grid->bank_name('البنك');
            $grid->mobile('رقم الجوال');
            $grid->email('البريد الالكتروني');
            $grid->created_at('تاريخ الإنشاء');
            $grid->updated_at('اخر تحديث');
        });
    }

    protected function detail($id)
    {
        $show = new Show(BankForm::findOrFail($id));

        $show->id('الرقم');
        $show->name('اسم المرسل');
        $show->amount('المبلغ');
        $show->date('تاريخ التحويل');
        $show->bank_name('اسم البنك');
        $show->mobile('الجوال');
        $show->email('البريد الالكتروني');
        $show->photo('صورة التحويل')->image();
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
        return Admin::form(BankForm::class, function (Form $form) {

            $form->display('id', 'الرقم');
            $form->text('name', 'الاسم')->rules('required');
            $form->currency('amount', 'المبلغ')->rules('required')->symbol('ر.س');
            $form->textarea('bank_name', 'البنك')->rules('required');
            $form->text('mobile', 'الجوال')->rules('required');
            $form->email('email', 'البريد الالكتروني');
            $form->date('date', 'تاريخ التحويل');
            $form->select('user_id', 'المستخدم')->options(User::pluck('name', 'id')->all())->rules('required');
            $form->image('photo', 'صورة التحويل')->uniqueName();
            $form->display('created_at', 'تاريخ الإنشاء');
            $form->display('updated_at', 'اخر تحديث');
        });
    }
}
