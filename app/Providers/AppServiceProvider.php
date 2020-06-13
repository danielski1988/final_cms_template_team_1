<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        
        /*
            boot method is loaded in any file anyways
            So $json variable is available to all the files
        */
        view()->composer('faculty.exam.layouts.filters', function($view)
        {
            //$path = "C:/xampp/htdocs/cms/public/json/CourseConfig.json";
            $path = URL::to('json/CourseConfig.json');
            $json = json_decode(file_get_contents($path), true);
            $view->with('json', $json);
        });
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
