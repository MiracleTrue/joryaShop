<?php

namespace App\Admin\Controllers;

use App\Models\User;

use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Show;

class UsersController extends Controller
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
            ->header('用户管理')
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
            ->header('用户详情')
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
            ->header('用户编辑')
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
            ->header('用户创建')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);

        /*筛选*/
        $grid->filter(function ($filter) {
            $filter->disableIdFilter(); // 去掉默认的id过滤器
            $filter->like('name', '用户名');
        });

        $grid->id('ID')->sortable();
        $grid->avatar('头像')->image('', 40);
        $grid->email('邮箱');
        $grid->name('用户名');
        $grid->created_at('创建时间')->sortable();

        // 不在页面显示 `新建` 按钮，因为我们不需要在后台新建用户
        $grid->disableCreateButton();

        return $grid;
    }

    /**
     * Make a form builder.
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User);

        $form->tools(function (Form\Tools $tools) {
//            $tools->disableDelete();
        });

        $form->display('id', 'ID');
        $form->image('avatar', '头像')->uniqueName()->move('avatar/' . date('Ym', now()->timestamp))->rules('required|image');
        $form->display('name', '用户名');
        $form->display('created_at', '创建时间');
        $form->display('updated_at', '更新时间');

        return $form;
    }

    /**
     * Make a show builder.
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->panel()->tools(function ($tools) {
            $tools->disableDelete();
        });;


        $show->id('ID');
        $show->divider();
        $show->avatar('头像')->image('', 120);
        $show->email('邮箱');
        $show->name('用户名');
        $show->created_at('创建时间');
        $show->updated_at('更新时间');

        return $show;
    }
}
