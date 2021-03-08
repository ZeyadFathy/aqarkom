<?php

namespace App\Admin\Users;

use App\Admin\Users\User;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class UserController extends Controller
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
            ->header('المستخدمين')
            ->description('الأعضاء المسجلين')
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
            ->description('تفاصيل المستخدم')
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
            ->description('تعديل بيانات العضو')
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
            ->header('انشاء')
            ->description('اضافة عضو جديد')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);

        $grid->id('Id');
        $grid->email('البريد الالكتروني');
        $grid->name('الاسم');
        $grid->mobile('رقم الجوال');
        $grid->status('مفعل')->radio(
            [
                0 => 'لا',
                1 => 'نعم',
            ]
        );
        $grid->verified('موثق')->radio(
            [
                0 => 'لا',
                1 => 'نعم',
            ]
        );
        $grid->blacklist('محظور')->editable('select', [
            1 => 'نعم',
            0 => 'لا',
        ]);
        $grid->created_at('تاريخ التسجيل');
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
        $show = new Show(User::findOrFail($id));

        $show->id('الرقم');
        $show->email('البريد الالكتروني');
        $show->password('كلمة المرور');
        $show->name('الاسم');
        $show->mobile('رقم الجوال');
        $show->status('الحالة');
        $show->max('الحد الأقصي');
        $show->avatar('الصورة الشخصية')->image();
        $show->blacklist('حالة الحجب');
        $show->created_at('تاريخ التسجيل');
        $show->updated_at('اخر تعديل');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User);

        $form->email('email', 'Email');
        $form->password('password', 'كلمة المرور');
        $form->text('name', 'الإسم');
        $form->text('mobile', 'رقم الهاتف')->rules('required');
        $form->number('max', 'الحد الأقصي');
        $form->switch('status', 'Status')->default(-1);
        $form->image('avatar', 'Avatar');
        $form->switch('notify', 'Notify')->default(1);
        $form->switch('blacklist', 'Blacklist');
        $form->switch('verified', 'موثق');

        return $form;
    }
    public function store()
    {
        request()->request->set('password', bcrypt(request('password')));
        return $this->form()->store();
    }

    public function update($id)
    {
        if (request('password')) {
            request()->request->set('password', bcrypt(request('password')));
        }

        return $this->form()->update($id);
    }
}
