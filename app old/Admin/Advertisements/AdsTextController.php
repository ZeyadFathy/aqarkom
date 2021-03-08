<?php

namespace App\Admin\Advertisements;

use App\Admin\Advertisements\AdsTextData;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Admin\Filters\Filter;

class AdsTextController extends Controller
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
        return $content
            ->header('Edit')
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
        $grid = new Grid(new AdsTextData);

        $grid->id('Id');
        $grid->filter_id('Filter id');
        $grid->advertisement_id('Advertisement id');
        $grid->text('Text');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');
        $grid->deleted_at('Deleted at');

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
        $show = new Show(AdsTextData::findOrFail($id));

        $show->id('Id');
        $show->filter_id('Filter id');
        $show->advertisement_id('Advertisement id');
        $show->text('Text');
        $show->created_at('Created at');
        $show->updated_at('Updated at');
        $show->deleted_at('Deleted at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new AdsTextData);
        $form->select('filter_id', 'المواصفات')->options(Filter::pluck('title', 'id')->all());
        $form->text('text', 'نص');
        // $form->select('advertisement_id')->options(Advertisement::all()->pluck('title', 'id'))->value(request('advertisement_id'));
        $form->hidden('advertisement_id')->value(request('advertisement_id'));
        $form->saved(function (Form $form) {
            $id =  \request()->get('advertisement_id');
            $path  = '/admin/advertisements/'.$id.'/edit';
            return redirect($path);
            
        });

        return $form;
    }
}
