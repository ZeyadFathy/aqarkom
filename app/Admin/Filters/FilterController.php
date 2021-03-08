<?php

namespace App\Admin\Filters;

use App\Admin\Filters\Filter;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use App\Admin\Categories\Category;


class FilterController extends Controller
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
            ->header('الفلاتر')
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
            ->header('Detail')
            ->description('description')
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
        $ad_filter = Filter::FindOrFail($id);
        $type = $ad_filter->type;
        if($type != 1){
            return $content
                ->header('Edit')
                ->description('description')
                ->row($this->form()->edit($id))
                ->row(Admin::grid(FilterOption::class, function (Grid $grid) use ($id) {
                    $grid->setName('Options')
                        ->setTitle('الخيارات')
                        ->setRelation(Filter::find($id)->options())
                        ->resource('/../admin/FilterOption');
                    $grid->id();
                    $grid->title();
                    $grid->created_at();
    
                }));
        }
        else
        {
            return $content
            ->header('Edit')
            ->description('description')
            ->row($this->form()->edit($id));
        }
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
            ->header('فلتر')
            ->description('جديد')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Filter);
        $grid->id('الرقم');
        $grid->title('العنوان');
        $grid->category('القسم')->display(function ($category) {
            $x = isset($category['title_ar']) ? $category['title_ar'] : 1; 
            return "<span class='label label-success'>{$x}</span>";
        });        
        $grid->type('النوع')->using( [
            1 => 'اختيار نصي',
            2 => 'قائمة منسدلة',
            3 => 'اختيار متعدد'
        ] );
        $grid->Column('خيارات الفلتر')->display(function () {
            if ($this->type != 1) {
                return '<a class="btn btn-xs btn-success" title="أضف خيارات" onclick="" href="/admin/filters/'.$this->id.'/edit"><i class="fa fa-wrench"></i>خيارات الفلتر</a>';
            }
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
        $show = new Show(Filter::findOrFail($id));

        $show->id('Id');
        $show->title('العنوان');
        $show->type('النوع')->using( [
            1 => 'اختيار نصي',
            2 => 'قائمة منسدلة',
            3 => 'اختيار متعدد'
        ] );       
        $show->category('القسم', function ($category) {
            $category->title('اسم القسم');
        });      
        $show->created_at('Created at');
        $show->updated_at('Updated at');
        
        $ad_filter = Filter::FindOrFail($id);
        $type = $ad_filter->type;
        if($type!=1)
        {
            $show->options('الخيارات', function ($option) {
                $option->setResource('/../admin/FilterOption');
                $option->id();
                $option->title();
            });        
        }
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Filter);
        $form->text('title', 'العنوان')->rules('required');
        $form->select('category_id', 'القسم')->options(Category::pluck('title_ar', 'id')->all())->rules('required');
        $form->select('type','النوع')->options([
            1 => 'اختيار نصي',
            2 => 'قائمة منسدلة',
            3 => 'اختيار متعدد'
        ])->rules('required');
        $form->saved(function (Form $form) {
            $type =  \request()->get('type');
            $id =     $form->model()->id;
            if($type !=1){
                $path  = '/admin/filters/'.$id.'/edit';
                return redirect($path);
            }
        });
        
        

        return $form;
    }
}
