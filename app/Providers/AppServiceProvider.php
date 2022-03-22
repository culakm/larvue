<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        // nastavenie defaultnej dlzky stringu
        // pretoze ak sa string pouzije pri indexovani tak je defaultna dlzka 255 vela
        Schema::defaultStringLength(191);
        // api data ktore sa vracaju cez app/Http/Resources/.. potom nie su obalene v "data": []
        // ked je to vypnute, musime vue data hladat response.data.data
        //JsonResource::withoutWrapping(); 
    }
}
