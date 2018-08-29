<?php

namespace Soumen\Auction;

use Illuminate\Support\ServiceProvider;

class AuctionServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['auction'];
    }
}