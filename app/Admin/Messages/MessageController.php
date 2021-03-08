<?php

namespace App\Admin\Messages;

use App\Admin\Messages\Message;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Admin\Users\User;

class MessageController extends Controller
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
        $conversations = Conversation::all();
        return $content
            ->header('الرسائل')
            ->description('عرض الرسائل')
            //->body($this->grid());
            ->body(view('admin.Messages.index',compact('conversations')));
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
        $conversations = Conversation::all();
        $messages = Message::where('conversation_id',$id)->orderby('created_at','ASC')->get();
        return $content
            ->header('تفاصيل الرسالة')
            ->description('بيانات الرسالة')
            ->body(view('admin.Messages.index',compact('conversations','messages')));
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
            ->header('تعديل الرسالة')
            ->description('تعديل الرسالة')
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
        $grid = new Grid(new Message);

        $grid->id('الرقم');
        $grid->text('الرسالة');
        $grid->user()->name('اسم المستخدم');
        $grid->seen('تمت المشاهدة');
        $grid->conversation_id('رقم المحادثة');
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
        $show = new Show(Message::findOrFail($id));

        $show->id('الرقم');
        $show->text('الرسالة');
        $show->user()->name('الاسم');
        $show->seen('تمت المشاهدة');
        $show->conversation_id('رقم المحادثة');
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
        $form = new Form(new Message);

        $form->textarea('text', 'رسالة');
        $form->select('user_id', 'المستخدم')->options(User::pluck('name', 'id')->all())->rules('required');
        $form->switch('seen', 'تمت المشاهدة');
        $form->select('conversation_id', 'رقم المحادثة')->options(Conversation::pluck('id', 'id')->all())->rules('required');
        return $form;
    }
}
