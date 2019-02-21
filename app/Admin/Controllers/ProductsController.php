<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Ajax\Ajax_Delete;
use App\Http\Requests\Request;
use App\Admin\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\MessageBag;

class ProductsController extends Controller
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
            ->header('产品管理')
            ->description('产品 - 列表')
            ->body($this->grid($request));
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
            ->header('产品管理')
            ->description('产品 - 详情')
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
            ->header('产品管理')
            ->description('产品 - 编辑')
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
            ->header('产品管理')
            ->description('产品 - 新增')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     * @return Grid
     */
    protected function grid($request)
    {
        $category = ProductCategory::find($request->input('cid'));

        $grid = new Grid(new Product);
        $grid->model()->with('comments')->orderBy('created_at', 'desc'); // 设置初始排序条件

        if ($category) {
            $grid->model()->where('product_category_id', $category->id);
        }

        /*筛选*/
        $grid->filter(function ($filter) {
            $filter->disableIdFilter(); // 去掉默认的id过滤器
            $filter->like('name_zh', '名称(中文)');
            $filter->like('name_en', '名称(英文)');
        });

        $grid->id('ID');
        $grid->thumb('缩略图')->image('', 60);
        $grid->category()->name_zh('分类')->display(function ($data) {
            return "<a href='" . route('admin.products.index', ['cid' => $this->product_category_id]) . "'>$data</a>";
        });
        $grid->name_zh('名称(中文)')->display(function ($data) {
            return "<span style='width: 120px;display: inline-block;overflow: hidden'>$data</span>";
        });
        $grid->name_en('名称(英文)')->display(function ($data) {
            return "<span style='width: 120px;display: inline-block;overflow: hidden'>$data</span>";
        });
        $grid->stock('库存')->sortable();
        $grid->price('价格')->sortable();
        $grid->sales('销量')->sortable();

        $grid->column('', '选项')->switchGroup([
            'on_sale' => '售卖状态', 'is_index' => '首页推荐'
        ]);

        $grid->index('综合指数')->sortable();
        $grid->heat('人气')->sortable();
        $grid->comments('评论数')->count();

        return $grid;
    }

    /**
     * Make a show builder.
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Product::findOrFail($id));

        $options = [
            'is_base_size_optional' => true,
            'is_hair_colour_optional' => true,
            'is_hair_density_optional' => true,
        ];

        $show->id('ID');
        $show->name_zh('名称(中文)');
        $show->name_en('名称(英文)');
        $show->description_zh('描述(中文)');
        $show->description_en('名称(英文)');
        $show->thumb('缩略图')->image('', 80);
        $show->photos('相册')->as(function ($photos) {
            $text = '';
            foreach ($photos as $photo) {
                $url = starts_with($photo, ['http://', 'https://']) ? $photo : Storage::disk('public')->url($photo);
                $text .= '<img src="' . $url . '" style="margin:0 12px 12px 0;max-width:120px;max-height:200px" class="img">';
            }

            return $text;
        });

        // 2019-01-22
        $show->is_base_size_optional('SKU base_size 是否可选')->as(function ($item) use (&$options) {
            $options['is_base_size_optional'] = $item;
            return $item ? '<span class="label label-primary">ON</span>' : '<span class="label label-default">OFF</span>';
        });
        $show->is_hair_colour_optional('SKU hair_colour 是否可选')->as(function ($item) use (&$options) {
            $options['is_hair_colour_optional'] = $item;
            return $item ? '<span class="label label-primary">ON</span>' : '<span class="label label-default">OFF</span>';
        });
        $show->is_hair_density_optional('SKU hair_density 是否可选')->as(function ($item) use (&$options) {
            $options['is_hair_density_optional'] = $item;
            return $item ? '<span class="label label-primary">ON</span>' : '<span class="label label-default">OFF</span>';
        });
        // 2019-01-22

        $show->is_index('首页推荐')->as(function ($item) {
            return $item ? '<span class="label label-primary">ON</span>' : '<span class="label label-default">OFF</span>';
        });
        $show->on_sale('售卖状态')->as(function ($item) {
            return $item ? '<span class="label label-primary">ON</span>' : '<span class="label label-default">OFF</span>';
        });
        $show->price('价格');
        $show->shipping_fee('运费');
        $show->stock('库存');
        $show->sales('销量');
        $show->index('综合指数');
        $show->heat('人气');
        $show->created_at('创建时间');
        $show->updated_at('更新时间');
        $show->divider();
        $show->content_zh('详情介绍(中文)');
        $show->content_en('详情介绍(英文)');

        $show->category('商品分类', function ($category) {
            /*禁用*/
            $category->panel()->tools(function ($tools) {
                $tools->disableList();
                $tools->disableEdit();
                $tools->disableDelete();
            });

            /*属性*/
            $category->name_zh('名称(中文)');
            $category->name_en('名称(英文)');
        });

        $show->skus('SKU列表', function ($sku) use (&$options) {
            /*禁用*/
            $sku->disableActions();
            $sku->disableRowSelector();
            $sku->disableExport();
            $sku->disableFilter();
            $sku->disableCreateButton();
            $sku->disablePagination();

            /*属性*/
            $sku->name_zh('SKU 名称(中文)');
            $sku->name_en('SKU 名称(英文)');
            $sku->price('单价');
            $sku->stock('剩余库存');
            $sku->sales('销量');

            // 2019-01-22
            if ($options['is_base_size_optional']) {
                $sku->base_size_zh('Base Size 名称(中文)');
                $sku->base_size_en('Base Size 名称(英文)');
            }
            if ($options['is_hair_colour_optional']) {
                $sku->hair_colour_zh('Hair Colour 名称(中文)');
                $sku->hair_colour_en('Hair Colour 名称(英文)');
            }
            if ($options['is_hair_density_optional']) {
                $sku->hair_density_zh('Hair Density 名称(中文)');
                $sku->hair_density_en('Hair Density 名称(英文)');
            }
            // 2019-01-22
        });

        $show->comments('评价列表', function ($comment) {
            /*禁用*/
            $comment->disableRowSelector();
            $comment->disableExport();
            $comment->disableFilter();
            $comment->disableCreateButton();

            $comment->actions(function ($actions) {
                $actions->disableView();
                $actions->disableEdit();
                $actions->disableDelete();
                if ($actions->row->deleted_at == null)// 可以删除的评论
                {
                    $actions->append(new Ajax_Delete(route('admin.product_comments.delete', [$actions->getKey()])));
                }
            });

            /*属性*/
            $comment->user()->name('买家');
            $comment->photo_urls('图片')->display(function ($urls) {
                $text = '';
                foreach ($urls as $url) {
                    $text .= '<img src="' . $url . '" style="margin:0 8px 8px 0;max-width:80px;max-height:80px" class="img">';
                }
                return $text;
            });
            $comment->content('内容')->display(function ($data) {
                return "<span style='width: 220px;display: inline-block;overflow: hidden'>$data</span>";
            });
            $comment->composite_index('综合评分');
            $comment->description_index('描述相符');
            $comment->shipment_index('物流服务');

            $comment->created_at('评价时间');
        });

        return $show;
    }

    /**
     * Make a form builder.
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Product());

        $form->tab('基础', function ($form) {

            $form->select('product_category_id', '商品分类')->options(ProductCategory::selectOptions())->rules('required|exists:product_categories,id');
            $form->text('name_zh', '名称(中文)')->rules('required');
            $form->text('name_en', '名称(英文)')->rules('required');
            $form->text('description_zh', '描述(中文)')->rules('required');
            $form->text('description_en', '描述(英文)')->rules('required');
            $form->multipleImage('photos', '相册')->uniqueName()->removable()->resize(420, 380)
                ->move('original/' . date('Ym', now()->timestamp))
                ->help('相册尺寸:420 * 380')->rules('image');

            // 2019-01-22
            // $form->switch('is_base_size_optional', 'SKU base_size 是否可选')->value(1);
            $form->switch('is_base_size_optional', 'SKU base_size 是否可选')->default(1);
            // $form->switch('is_hair_colour_optional', 'SKU hair_colour 是否可选')->value(1);
            $form->switch('is_hair_colour_optional', 'SKU hair_colour 是否可选')->default(1);
            // $form->switch('is_hair_density_optional', 'SKU hair_density 是否可选')->value(1);
            $form->switch('is_hair_density_optional', 'SKU hair_density 是否可选')->default(1);
            // 2019-01-22

            // $form->switch('on_sale', '售卖状态')->value(1);
            $form->switch('on_sale', '售卖状态')->default(1);
            $form->switch('is_index', '首页推荐');

        })->tab('价格与库存', function ($form) {

            $form->display('price', '价格')->setWidth(2);
            $form->display('stock', '库存')->setWidth(2);
            $form->display('sales', '销量')->setWidth(2);
            // $form->currency('shipping_fee', '运费')->symbol('￥')->rules('required');
            $form->currency('shipping_fee', '运费')->symbol('$')->rules('required');

            $form->hasMany('skus', 'SKU 列表', function (Form\NestedForm $form) {
                $form->text('name_zh', 'SKU 名称(中文)')->rules('required');
                // $form->text('name_en', 'SKU 名称(英文)')->rules('required')->default('');
                // $form->currency('price', '单价')->symbol('￥')->rules('required|numeric|min:0.01');
                $form->currency('price', '单价')->symbol('$')->rules('required|numeric|min:0.01');
                $form->number('stock', '剩余库存')->min(0)->rules('required|integer|min:0');
                $form->display('sales', '销量')->setWidth(2);

                // 2019-01-22
                $form->text('base_size_zh', 'Base Size 名称(中文)')->default('');
                $form->text('base_size_en', 'Base Size 名称(英文)')->default('');
                $form->text('hair_colour_zh', 'Hair Colour 名称(中文)')->default('');
                $form->text('hair_colour_en', 'Hair Colour 名称(英文)')->default('');
                $form->text('hair_density_zh', 'Hair Density 名称(中文)')->default('');
                $form->text('hair_density_en', 'Hair Density 名称(英文)')->default('');
                // 2019-01-22
            });

        })->tab('商品详细', function ($form) {

            $form->number('index', '综合指数')->min(0)->rules('required|integer|min:0');
            $form->number('heat', '人气')->min(0)->rules('required|integer|min:0');

            $form->divider();
            $form->editor('content_zh', '详情介绍(中文)');
            $form->editor('content_en', '详情介绍(英文)');


            $form->hidden('_from_')->default('edit');
            $form->ignore(['_from_']);
        });


        // 定义事件回调，当模型即将保存时会触发这个回调
        $form->saving(function (Form $form) {

            if (request()->input('photos') != '_file_del_') {
                $skus = collect($form->input('skus'))->where(Form::REMOVE_FLAG_NAME, 0);
                $base_size_option = collect($form->input('is_base_size_optional'))->values();
                $is_base_size_optional = ($base_size_option[0] == 'on');
                $hair_colour_option = collect($form->input('is_hair_colour_optional'))->values();
                $is_hair_colour_optional = ($hair_colour_option[0] == 'on');
                $hair_density_option = collect($form->input('is_hair_density_optional'))->values();
                $is_hair_density_optional = ($hair_density_option[0] == 'on');

                if (request()->input('_from_') == 'edit' && $skus->isEmpty()) {
                    $error = new MessageBag([
                        'title' => 'SKU 列表 必须填写',
                    ]);
                    // return back()->withInput()->with(compact('error'));
                    return back()->with(compact('error')); // The method withInput() is buggy with unwanted results.
                }

                if ($skus->isNotEmpty()) {
                    $count = $skus->count();

                    // name_zh
                    $sku_name_zhs = $skus->unique('name_zh');
                    if ($sku_name_zhs->count() < $count) {
                        $error = new MessageBag([
                            'title' => 'SKU 列表：存在SKU-中文名称重复问题，请确保同款商品下的各个SKU-中文名称唯一',
                        ]);
                        // return back()->withInput()->with(compact('error'));
                        return back()->with(compact('error')); // The method withInput() is buggy with unwanted results.
                    }

                    // base_size  hair_colour hair_density
                    if ($is_base_size_optional || $is_hair_colour_optional || $is_hair_density_optional) {
                        $sku_parameter = '';
                        $is_first_time = true;
                        if ($is_base_size_optional) {
                            $sku_parameter = $is_first_time ? 'Base Size' : ' & Base Size';
                            $is_first_time = false;
                        }
                        if ($is_hair_colour_optional) {
                            $sku_parameter .= $is_first_time ? 'Hair Colour' : ' & Hair Colour';
                            $is_first_time = false;
                        }
                        if ($is_hair_density_optional) {
                            $sku_parameter .= $is_first_time ? 'Hair Density' : ' & Hair Density';
                            $is_first_time = false;
                        }

                        $sku_parameter_ens = $skus->map(function ($item, $key) use ($is_base_size_optional, $is_hair_colour_optional, $is_hair_density_optional) {
                            $parameter_en = '* ' . ($is_base_size_optional ? $item['base_size_en'] : '');
                            $parameter_en .= ' * ' . ($is_hair_colour_optional ? $item['hair_colour_en'] : '');
                            $parameter_en .= ' * ' . ($is_hair_density_optional ? $item['hair_density_en'] : '') . ' *';
                            return $parameter_en;
                        });
                        if ($sku_parameter_ens->unique()->count() < $count) {
                            $error = new MessageBag([
                                'title' => 'SKU 列表：存在SKU-英文参数组合(' . $sku_parameter . ')重复问题，请确保同款商品下的各个SKU-英文参数组合(' . $sku_parameter . ')唯一',
                            ]);
                            // return back()->withInput()->with(compact('error'));
                            return back()->with(compact('error')); // The method withInput() is buggy with unwanted results.
                        }

                        $sku_parameter_zhs = $skus->map(function ($item, $key) use ($is_base_size_optional, $is_hair_colour_optional, $is_hair_density_optional) {
                            $parameter_zh = '* ' . ($is_base_size_optional ? $item['base_size_zh'] : '');
                            $parameter_zh .= ' * ' . ($is_hair_colour_optional ? $item['hair_colour_zh'] : '');
                            $parameter_zh .= ' * ' . ($is_hair_density_optional ? $item['hair_density_zh'] : '') . ' *';
                            return $parameter_zh;
                        });
                        if ($sku_parameter_zhs->unique()->count() < $count) {
                            $error = new MessageBag([
                                'title' => 'SKU 列表：存在SKU-中文参数组合(' . $sku_parameter . ')重复问题，请确保同款商品下的各个SKU-中文参数组合(' . $sku_parameter . ')唯一',
                            ]);
                            // return back()->withInput()->with(compact('error'));
                            return back()->with(compact('error')); // The method withInput() is buggy with unwanted results.
                        }
                    }
                }

                $form->ignore(['_from_']);

                $form->model()->price = collect($form->input('skus'))->where(Form::REMOVE_FLAG_NAME, 0)->min('price'); // 生成商品价格 - 最低SKU价格
                $form->model()->stock = collect($form->input('skus'))->where(Form::REMOVE_FLAG_NAME, 0)->sum('stock'); // 生成商品库存 - 求和SKU库存
            }
        });
        return $form;
    }
}
