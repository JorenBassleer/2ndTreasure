<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use Illuminate\Support\Facades\Auth;
use App\Goodiebag;
use Carbon\Carbon;
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
        // Get all goodiebags that have not been delivered yet
        // And are updated less than 7 days ago and where the code is still valid
        // Not the best way to do this (i think) but can't find another way
        $onGoingGoodiebags = Goodiebag::where([
            ['hasReceived', '=',  null],
            ['updated_at', '>', Carbon::now()->subDays(7)]])->whereNotNull('code')->get();
        View::share('onGoingGoodiebags',$onGoingGoodiebags);
    }
}
