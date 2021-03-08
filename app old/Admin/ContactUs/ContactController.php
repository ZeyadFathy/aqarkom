<?php

namespace App\Admin\ContactUs;

use App\Admin\ContactUs\Contact;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Admin\Users\User;

class ContactController extends Controller
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
            ->header('طلبات التواصل')
            ->description('طلبات المستخدمين')
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
            ->description('بيانات الطلب')
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
            ->description('تعديل طلب التواصل')
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
            ->description('طلب تواصل جديد')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Contact);

        $grid->id('الرقم');
        $grid->title('العنوان');
        $grid->user()->name('المستخدم');
        $grid->email('البريد الالكتروني');
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
        $show = new Show(Contact::findOrFail($id));

        $show->id('الرقم');
        $show->title('العنوان');
        $show->message('الرسالة');
        $show->user()->as(function ($user) {
            return !empty($user->name) ? "{$user->name}" : '';
        });

        $show->email('البريد الإلكتروني');
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
        $form = new Form(new Contact);

        $form->text('title', 'العنوان');
        $form->textarea('message', 'الرسالة');
        $form->select('user_id', 'المستخدم')->options(User::pluck('name', 'id')->all())->rules('required');
        $form->email('email', 'Email');

        return $form;
    }
}
