<?php

namespace App\Providers;

use App\Category;
use App\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        if (Cache::has('cats')){
            $cats = Cache::get('cats');
        }else{
            try{
                $cats = Category::withCount('posts')
                    ->orderBy('posts_count', 'desc')
                    ->get();
                Cache::put('cats', $cats, 30);
            }catch (\Exception $ex){
                return;
            }

        }


        view()->composer('layouts.sidebar', function ($view)  use ($cats){
            $view->with('popular_posts', Post::orderBy('views', 'desc')
                ->limit(3)
                ->get()
            );
            $view->with('cats', $cats);
        });
    }
}
