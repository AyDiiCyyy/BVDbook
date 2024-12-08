<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $category = Category::query()
        ->where('status',1)
        ->orderBy('id','desc')->get();
        View::share('categoryAll', $category);
        Paginator::useBootstrapFive();

        View::composer('*', function ($view) {
            if (Auth::check()) {
                $cartItemCount = Cart::where('user_id', Auth::id())->sum('quantity');
                $view->with('cartItemCount', $cartItemCount);
            } else {
                $view->with('cartItemCount', 0);
            }
        });
    }
}
