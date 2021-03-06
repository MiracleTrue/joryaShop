<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\CountryCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Using Closure based composers...
        View::composer([
            'layouts._header',
            'layouts._footer_mobile',
        ], function ($view) {
            $cart_count = 0;
            if (Auth::check()) {
                $cart_count = Cart::where('user_id', Auth::id())->count();
            } else {
                $cart = session('cart', []);
                $cart_count = count($cart);
            }
            $view->with('cart_count', $cart_count);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
