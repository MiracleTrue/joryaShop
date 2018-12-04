<?php

namespace App\Admin\Controllers;

use App\Models\Article;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Validation\Rule;

class ArticlesController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('文章管理')
            ->description('列表')
            ->body($this->grid());
    }

    /**
     * Show interface.
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('文章管理')
            ->description('详情')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('文章管理')
            ->description('编辑')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('文章管理')
            ->description('新增')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article);
        $grid->disableFilter();


        $grid->id('ID');
        $grid->name('名称');
        $grid->slug('标示位');
        $grid->created_at('创建时间');
        $grid->updated_at('更新时间');

        return $grid;
    }

    /**
     * Make a show builder.
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Article::findOrFail($id));

        $show->id('ID');
        $show->name('名称');
        $show->slug('标示位');
        $show->content_zh('内容(中文)');
        $show->divider();
        $show->content_en('内容(英文)');
        $show->created_at('创建时间');
        $show->updated_at('更新时间');

        return $show;
    }

    /**
     * Make a form builder.
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Article);

        $form->text('name', '名称');
        $form->text('slug', '标示')->rules(function ($form) {
            return ['required', Rule::unique('articles', 'slug')->ignore($form->model()->id),];
        })->help(
            '可使用的标示 : ' .
            'about | company_introduction | products_features | contact_us | helper | guide | problem | user_protocol | refunding_service | refunding_consultancy | refunding_policy | refunding_procedure'
        );
        // })->help('可使用的标示 : about | guide | problem | user_protocol | service');
        $form->text('slug', '标示位');
        $form->editor('content_zh', '内容(中文)');
        $form->editor('content_en', '内容(英文)');

        return $form;
    }
}
