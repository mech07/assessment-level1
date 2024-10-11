<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserSaved::class => [
            SaveUserBackgroundInformation::class,
        ],
    ];

    public function boot()
    {
        parent::boot();

        // You can register any additional event listeners here
    }
}
