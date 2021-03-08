<?php

namespace App\Admin\Notifications;

use App\Admin\Notifications\Notification;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Admin\Users\User;
use App\Admin\Messages\Conversation;
use App\Models\NotificationToken;
use Illuminate\Http\Request;
use App\Helpers\ApiHelper;


class NotificationController extends Controller
{
    use HasResourceActions;

    public $helper;


    private $notificationToken;
    /**
     * @var UserDevice
     */
    private $userDevice;

    public function __construct(//NotificationFirebase $notificationFirebase,
                                NotificationToken $notificationToken,
                                UserDevice $userDevice
                                )
    {
        //$this->notificationFirebase = $notificationFirebase;
        $this->notificationToken = $notificationToken;
        $this->userDevice = $userDevice;
        $this->helper = new ApiHelper();
        //$this->notification = $notification;
    }

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('الإشعارات')
            ->description('اشعارات التطبيق')
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
            ->header('تفاصيل الإشعار')
            ->description('تفاصيل الإشعار')
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
            ->description('تعديل بيانات الإشعار')
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
            ->header('اضافة اشعار')
            ->description('اشعار جديد')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Notification);

        $grid->id('الرقم');
        $grid->title('الإشعار');
        $grid->user()->name('المستقبل');
        $grid->notifier_user()->name('المرسل');
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
        $show = new Show(Notification::findOrFail($id));

        $show->id('Id');
        $show->title('Title');
        $show->user_id('User id');
        $show->notifier_user()->name('الاسم');
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
        $form = new Form(new Notification);

        $form->text('title', 'الإشعار');
        $form->select('user_id', 'المستخدم')->options(User::pluck('name', 'id')->all())->rules('required');
        $form->select('notifier', 'مرسل الاشعار')->options(User::pluck('name', 'id')->all())->rules('required');
        $form->select('conversation_id', 'رقم المحادثة')->options(Conversation::pluck('id', 'id')->all())->rules('required');

        return $form;
    }



    public function registerToken(Request $request)
    {
        $user_id = auth()->user()->id;
        $this->notificationToken->firstOrCreate(['fcm_token' => $request->fcm_token]);
        $userDevice = $this->userDevice->firstOrCreate([
            'fcm_token' => $request->fcm_token,
            'user_id'   => $user_id
        ]);
        $userDevice->active = 'on';
        $userDevice->save();
        return response()->json([
            'msg' => "success",
            'data' => $userDevice,
            'status' => true
        ]);
    }

    public function setNotificationToken(Request $request)
    {
        // return GenericResponder::make();
        $data = $this->notificationToken->firstOrCreate(['fcm_token' => $request->fcm_token]);

        return response()->json([
            'msg' => "success",
            'data' => $data,
            'status' => true
        ]);
    }


    public function toggleToken(Request $request)
    {
        $user_id = auth()->user()->id;
        $data = $this->userDevice->where('user_id', $user_id)->update(['active'=> $request->active]);
        if($data) {
            return response()->json([
            'msg' => "success",
            'data' => $data,
            'status' => true
            ]);
        }else{

            return response()->json([
            'msg' => "Not Found",
            'data' => null,
            'status' => 404
            ]);

        }
    }

    public function logoutToken(Request $request)
    {
        $user_id = auth()->user()->id;
        $userDevice = $this->userDevice->where('user_id', $user_id)->where('fcm_token', $request->fcm_token)->first();
        if($userDevice) {
            $userDevice->active = 'logout';
            $userDevice->update();
            
           return response()->json([
            'msg' => "success",
            'data' => $userDevice,
            'status' => true
        ]);
        }

            return response()->json([
            'msg' => "Not Found",
            'data' => null,
            'status' => 404
            ]);

    }
}
