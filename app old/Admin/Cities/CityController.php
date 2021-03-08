<?php

namespace App\Admin\Cities;

use App\Admin\Cities\City;
use App\Admin\Cities\Region;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CityController extends Controller
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
            ->header('المدن')
            ->description('المدن')
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
            ->description('تفاصيل المدينة')
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
            ->description('تعديل بيانات المدينة')
            ->body($this->form()->edit($id))
            ->row(Admin::grid(Region::class, function (Grid $grid) use ($id) {
                $grid->setName('regions')
                    ->setTitle('الأحياء')
                    ->setRelation(City::find($id)->regions())
                    ->resource('/../admin/regions');
                $grid->id('الرقم');
                $grid->title('اسم الحي');
                $grid->created_at('تاريخ الإنشاء');
            }));

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
            ->header('إضافة مدينة')
            ->description('مدينة جديدة')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new City);

        $grid->id('الرقم');
        $grid->title('الاسم');
        $grid->title_en('الاسم انجليزي');
        $grid->Column('احياء المدينة')->display(function () {
            return '<a class="btn btn-xs btn-success" title="اضافة احياء" onclick="" href="/admin/cities/' . $this->id . '/edit"><i class="fa fa-wrench"></i>احياء المدينة</a>';
        });
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
        $show = new Show(City::findOrFail($id));

        $show->id('الرقم');
        $show->title('الاس');
        $show->title_en('الاس');
        $show->vlong('الاحداثي الطول الوهمي');
        $show->vlat('احداثي العرض الوهمي');
        $show->rlong('احداثي الطول الفعلي');
        $show->rlat('احداثي العرض الفعلي');
        $show->created_at('تاريخ الإنشاء');
        $show->updated_at('اخر تحديث');
        $show->regions('الأحياء', function ($region) {
            $region->setResource('/../admin/regions');
            $region->id('الرقم');
            $region->title('اسم الحي');
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
        $form = new Form(new City);

        $form->text('title', 'اسم المدينة');
        $form->text('title_en', 'اسم المدينة - انجليزي');
        $form->map('vlat', 'vlong', 'الاحداثيات الوهمية')->rules('required');
        $form->map('rlat', 'rlong', 'الاحداثيات الفعلية')->rules('required');
        $form->saved(function (Form $form) {
            $id =     $form->model()->id;
            $path = '/admin/cities/' . $id . '/edit';
            return redirect($path);
        });
        return $form;
    }
}
