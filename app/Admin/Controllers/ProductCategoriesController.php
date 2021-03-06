<?php

namespace App\Admin\Controllers;

use App\Http\Requests\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Tree;

class ProductCategoriesController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     * @param Content $content
     * @return Content
     */
    public function index(Content $content, Request $request)
    {
        return $content
            ->header('商品管理')
            ->description('类别 - 列表')
            ->body($this->tree());
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
            ->header('商品管理')
            ->description('类别 - 详情')
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
            ->header('商品管理')
            ->description('类别 - 编辑')
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
            ->header('商品管理')
            ->description('类别 - 新增')
            ->body($this->form());
    }

    protected function tree()
    {
        return ProductCategory::tree(function (Tree $tree) {
            $tree->branch(function ($branch) {
                $text = $branch['is_index'] && !$branch['parent_id'] ? '<span class="label label-success">首页显示</span>' : '';
                // return "ID:{$branch['id']} - {$branch['name_zh']} " . $text;
                return "ID:{$branch['id']} - {$branch['name_en']} " . $text;
            });
        });
    }

    /**
     * Make a grid builder.
     * @return Grid
     */
    //    protected function grid(Request $request)
    //    {
    //        $parent_category = ProductCategory::find($request->input('pid'));
    //
    //        $grid = new Grid(new ProductCategory);
    //
    //        /*筛选*/
    //        $grid->filter(function ($filter) {
    //            $filter->disableIdFilter(); // 去掉默认的id过滤器
    //            $filter->like('name_zh', '名称(中文)');
    //        });
    //
    //        if ($parent_category) {
    //            $grid->model()->where('parent_id', $parent_category->id);
    //        } else {
    //            $grid->model()->where('parent_id', 0);
    //        }
    //
    //        $grid->id('ID');
    //        $grid->name_zh('名称(中文)');
    //        $grid->name_en('名称(英文)');
    //
    //        if ($parent_category) {
    //            $grid->parent_category()->name_zh('上级分类');
    //        } else {
    //            // 是否首页显示
    //            $states = [
    //                'on' => ['value' => true, 'text' => '已开启', 'color' => 'primary'],
    //                'off' => ['value' => false, 'text' => '已关闭', 'color' => 'default'],
    //            ];
    //            $grid->is_index('首页显示')->switch($states);
    //
    //            // 选项
    //            $grid->column('option', '选项')->display(function () {
    //                return '<a href="' . route('admin.product_categories.index', ['pid' => $this->id]) . '" class="btn btn-xs btn-primary" style="margin-right: 10px">查看下级分类 <span class="badge">' . count($this->child_categories) . '</span></a>';
    //            });
    //        }
    //
    //        return $grid;
    //    }

    /**
     * Make a show builder.
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(ProductCategory::findOrFail($id));

        $show->id('ID');
        // $show->name_zh('名称(中文)');
        $show->name_en('名称(英文)');
        // $show->description_zh('描述(中文)');
        $show->description_en('描述(英文)');
        // $show->content_zh('内容(中文)');
        $show->content_en('内容(英文)');

        /* 2019-04-09 for SEO */
        $show->divider();
        $show->seo_title('SEO - 标题');
        $show->seo_keywords('SEO - 关键字');
        $show->seo_description('SEO - 描述');
        $show->divider();
        /* 2019-04-09 for SEO */

        $show->is_index('首页显示')->as(function ($item) {
            return $item ? '<span class="label label-primary">ON</span>' : '<span class="label label-default">OFF</span>';
        });
        $show->created_at('创建时间');
        $show->updated_at('更新时间');

        $show->parent('上级栏目', function ($parent_category) {
            $parent_category->id('ID');
            // $parent_category->name_zh('名称(中文)');
            $parent_category->name_en('名称(英文)');
        });

        return $show;
    }

    /**
     * Make a form builder.
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ProductCategory);

        /*$parent_categories = ProductCategory::where('parent_id', 0)->get()->mapWithKeys(function ($item) {
            // return [$item['id'] => $item['name_zh']];
            return [$item['id'] => $item['name_en']];
        });
        $parent_categories->prepend('顶级分类', 0);*/

        $form->select('parent_id', '上级分类')->options(ProductCategory::selectOptions())->rules('required');
        // $form->text('name_zh', '名称(中文)')->rules('required');
        $form->hidden('name_zh', '名称(中文)')->default('lyrical');
        $form->text('name_en', '名称(英文)')->rules('required|string');

        /* 2019-04-09 for SEO */
        $form->text('seo_title', 'SEO - 标题');
        $form->text('seo_keywords', 'SEO - 关键字');
        $form->text('seo_description', 'SEO - 描述');
        /* 2019-04-09 for SEO */

        // $form->text('description_zh', '描述(中文)')->rules('required');
        $form->hidden('description_zh', '描述(中文)')->default('lyrical');
        $form->editor('description_en', '描述')->rules('required');
        $form->hidden('content_zh', '内容(中文)')->default('lyrical');
        $form->editor('content_en', '底部文章');

        $form->image('banner', '分类主页图')->uniqueName()->move('banners')->removable()->help('尺寸:720 * 230');

        $form->switch('is_index', '首页显示');
        $form->number('sort', '排序值')->default(9)->rules('required|integer|min:0');

        // 定义事件回调，当模型即将保存时会触发这个回调
        $form->saving(function (Form $form) {
            $form->model()->slug = null;
        });

        return $form;
    }
}
