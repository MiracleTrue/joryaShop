<?php

/*商品属性 2019-03-01*/
//namespace App\Admin\Controllers;
//
//use App\Http\Requests\Request;
//use App\Models\Attr;
//use App\Http\Controllers\Controller;
//use Encore\Admin\Controllers\HasResourceActions;
//use Encore\Admin\Form;
//use Encore\Admin\Grid;
//use Encore\Admin\Layout\Content;
//use Encore\Admin\Show;
//use Encore\Admin\Tree;
//
//class AttrsController extends Controller
//{
//    use HasResourceActions;
//
//    /**
//     * Index interface.
//     * @param Content $content
//     * @return Content
//     */
//    public function index(Content $content, Request $request)
//    {
//        return $content
//            ->header('产品属性管理')
//            ->description('属性 - 列表')
//            ->body($this->tree());
//    }
//
//    /**
//     * Show interface.
//     * @param mixed $id
//     * @param Content $content
//     * @return Content
//     */
//    public function show($id, Content $content)
//    {
//        return $content
//            ->header('产品属性管理')
//            ->description('属性 - 详情')
//            ->body($this->detail($id));
//    }
//
//    /**
//     * Edit interface.
//     * @param mixed $id
//     * @param Content $content
//     * @return Content
//     */
//    public function edit($id, Content $content)
//    {
//        return $content
//            ->header('产品属性管理')
//            ->description('属性 - 编辑')
//            ->body($this->form()->edit($id));
//    }
//
//    /**
//     * Create interface.
//     * @param Content $content
//     * @return Content
//     */
//    public function create(Content $content)
//    {
//        return $content
//            ->header('产品属性管理')
//            ->description('属性 - 新增')
//            ->body($this->form());
//    }
//
//    protected function tree()
//    {
//        return Attr::tree(function (Tree $tree) {
//            $tree->branch(function ($branch) {
//                return "ID:{$branch['id']} - {$branch['name_en']} ";
//            });
//        });
//    }
//
//    /**
//     * Make a grid builder.
//     * @return Grid
//     */
////    protected function grid(Request $request)
////    {
////        $parent_category = Attr::find($request->input('pid'));
////
////        $grid = new Grid(new Attr);
////
////        /*筛选*/
////        $grid->filter(function ($filter) {
////            $filter->disableIdFilter(); // 去掉默认的id过滤器
////            $filter->like('name_zh', '名称(中文)');
////        });
////
////        if ($parent_category) {
////            $grid->model()->where('parent_id', $parent_category->id);
////        } else {
////            $grid->model()->where('parent_id', 0);
////        }
////
////        $grid->id('ID');
////        $grid->name_zh('名称(中文)');
////        $grid->name_en('名称(英文)');
////
////        if ($parent_category) {
////            $grid->parent_category()->name_zh('上级属性');
////        } else {
////            // 是否首页显示
////            $states = [
////                'on' => ['value' => true, 'text' => '已开启', 'color' => 'primary'],
////                'off' => ['value' => false, 'text' => '已关闭', 'color' => 'default'],
////            ];
////            $grid->is_index('首页显示')->switch($states);
////
////            // 选项
////            $grid->column('option', '选项')->display(function () {
////                return '<a href="' . route('admin.product_categories.index', ['pid' => $this->id]) . '" class="btn btn-xs btn-primary" style="margin-right: 10px">查看下级属性 <span class="badge">' . count($this->child_categories) . '</span></a>';
////            });
////        }
////
////        return $grid;
////    }
//
//    /**
//     * Make a show builder.
//     * @param mixed $id
//     * @return Show
//     */
//    protected function detail($id)
//    {
//        $show = new Show(Attr::findOrFail($id));
//
//        $show->id('ID');
//
//        // $show->name_zh('名称(中文)');
//        $show->name_en('名称(英文)');
//
//        $show->created_at('创建时间');
//        $show->updated_at('更新时间');
//
//        $show->parent('上级栏目', function ($parent_category) {
//            $parent_category->id('ID');
//            // $parent_category->name_zh('名称(中文)');
//            $parent_category->name_en('名称(英文)');
//        });
//
//        return $show;
//    }
//
//    /**
//     * Make a form builder.
//     * @return Form
//     */
//    protected function form()
//    {
//        $form = new Form(new Attr);
//
//        $parent_categories = Attr::where('parent_id', 0)->get()->mapWithKeys(function ($item) {
//            // return [$item['id'] => $item['name_zh']];
//            return [$item['id'] => $item['name_en']];
//        });
//        $parent_categories->prepend('顶级属性', 0);
//
//        $form->select('parent_id', '上级属性')->options($parent_categories)->rules('required');
//        // $form->text('name_zh', '名称(中文)')->rules('required');
//        $form->hidden('name_zh', '名称(中文)')->default('lyrical');
//        $form->text('name_en', '名称(英文)')->rules('required');
//        $form->number('sort', '排序值');
//
//        return $form;
//    }
//}
/*商品属性 2019-03-01*/