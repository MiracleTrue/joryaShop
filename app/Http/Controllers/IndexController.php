<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\ImageUploadRequest;
use App\Models\Banner;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    public function root(Request $request)
    {
        $banners = Banner::where('type', 'index')->latest()->get();

        $products = [];
        $categories = ProductCategory::where(['parent_id' => 0, 'is_index' => 1])->get();
        foreach ($categories as $category) {
            $children = $category->children;
            if ($children->isEmpty()) {
                continue;
            }
            $children_ids = $children->pluck('id')->all();
            $products[$category->id]['category'] = $category;
            $products[$category->id]['children'] = $children;
            $products[$category->id]['products'] = Product::where('is_index', 1)->whereIn('product_category_id', $children_ids)->orderByDesc('index')->limit(8)->get();
        }
        $guesses = Product::where(['is_index' => 1, 'on_sale' => 1])->orderByDesc('heat')->limit(8)->get();

        return view('index.root', [
            'banners' => $banners,
            'products' => $products,
            'guesses' => $guesses,
        ]);
    }

    // POST 获取上传图片预览
    public function imagePreview(ImageUploadRequest $request, ImageUploadHandler $handler)
    {
        $preview_path = $handler->uploadTemp($request->image);
        $preview_url = Storage::disk('public')->url($preview_path);
        return response()->json([
            'preview' => $preview_url,
        ]);
    }

    // POST 获取原上传图片路径+预览
    public function imageUpload(ImageUploadRequest $request, ImageUploadHandler $handler)
    {
        $path = $handler->uploadOriginal($request->image);
        $preview_path = $handler->uploadTemp($request->image);
        $preview_url = Storage::disk('public')->url($preview_path);
        return response()->json([
            'path' => $path,
            'preview' => $preview_url,
        ]);
    }

    // POST 获取评论上传图片路径+预览
    public function commentImageUpload(ImageUploadRequest $request, ImageUploadHandler $handler)
    {
        $path = $handler->uploadCommentImage($request->image, false, false, 240, 240);
        $preview_path = $handler->uploadTemp($request->image);
        $preview_url = Storage::disk('public')->url($preview_path);
        return response()->json([
            'path' => $path,
            'preview' => $preview_url,
        ]);
    }

    // GET 修改网站语言
    public function localeUpdate(Request $request, $locale)
    {
        $request->session()->put('GlobalLocale', $locale);
        return back();
    }
}
