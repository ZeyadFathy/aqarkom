<?php

namespace App\Admin\BankAccounts;

use App\Admin\BankAccounts\BankAccount;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class BankAccountController extends Controller
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
            ->header('الحسابات البنكية')
            ->description('الحسابات البنكية')
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
            ->description('تفاصيل الحساب البنكي')
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
            ->description('تعديل بيانات الحساب')
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
            ->description('إضافة حساب جديد')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new BankAccount);

        $grid->id('الرقم');
        $grid->bank_name('اسم البنك');
        $grid->account_name('اسم صاحب الحساب');
        $grid->account_no('رقم الحساب');
        $grid->iban('Iban');
        $grid->created_at('تاريخ الإضافة');
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
        $show = new Show(BankAccount::findOrFail($id));

        $show->id('الرقم');
        $show->bank_name('اسم البنك');
        $show->account_name('اسم صاحب الحساب');
        $show->account_no('رقم الحساب');
        $show->iban('Iban');
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
        $form = new Form(new BankAccount);

        $form->text('bank_name', 'اسم البنك');
        $form->text('account_name', 'اسم صاحب الحساب');
        $form->text('account_no', 'رقم الحساب');
        $form->text('iban', 'Iban');

        return $form;
    }
}
