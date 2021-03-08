<?php

namespace App\Admin\Messages;

use App\Admin\Messages\Conversation;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ConversationController extends Controller
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
            ->header('المحادثات')
            ->description('عرض المحادثات')
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
            ->header('تفاصيل المحادثة')
            ->description('عرض المحادثة')
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
            ->header('تعديل المحادثة')
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
        $grid = new Grid(new Conversation);

        $grid->id('الرقم');
        $grid->one()->name('الطرف الأول');
        $grid->two()->name('الطرف الثاني');
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
        $show = new Show(Conversation::findOrFail($id));

        $show->id('الرقم');
        $show->one()->name('الطرف الأول');
        $show->two()->name('الطرف الثاني');
        $show->last('Last');
        $show->created_at('تاريخ الانشاء');
        $show->updated_at('اخر تحديث');
        $show->messages('الرسائل', function ($message) {
            $message->setResource('/../admin/messages');
            $message->id('الرقم');
            $message->user()->name('اسم المرسل');
            $message->text('الرسالة');
        });
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Conversation);

        $form->number('user_one', 'User one');
        $form->number('user_two', 'User two');
        $form->datetime('last', 'Last')->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
