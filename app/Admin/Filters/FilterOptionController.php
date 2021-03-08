<?php

namespace App\Admin\Filters;

use App\Admin\Filters\FilterOption;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Admin\Filters\Filter;

class FilterOptionController extends Controller
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
            ->header('Index')
            ->description('description')
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
            ->description('تفاصيل الخيار')
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
            ->description('تعديل الخيار')
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
            ->header('خيار جديد')
            ->description('أضف خيار جديد')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new FilterOption);
        if ($ads_filter = request('filter_id')) {
            $grid->model()->Ofads_filter($ads_filter);
        }

        $grid->id('Id');
        $grid->title('Title');
        $grid->ads_filter('الفلتر')->display(function ($ads_filter){
            return "<span class='label label-success'>{$ads_filter['title']}</span>";
        });
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

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
        $show = new Show(FilterOption::findOrFail($id));

        $show->id('Id');
        $show->title('Title');
        $show->filter_id('Filter id');
        $show->deleted_at('Deleted at');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new FilterOption);

        $form->text('title', 'العنوان');
        $form->select('filter_id','الفلتر')->options(Filter::all()->pluck('title', 'id'))->value(request('filter_id'));
        $form->saved(function (Form $form) {
            $id =  \request()->get('filter_id');
            $path  = '/admin/filters/'.$id.'/edit';
            return redirect($path);
            
        });
        return $form;
    }
}
