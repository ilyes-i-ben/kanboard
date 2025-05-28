<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers;


class EventServiceProvider extends Providers\EventServiceProvider
{
    protected $listen = [
        Registered::class => [
        ]
    ];
}
