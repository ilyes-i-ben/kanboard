<?php

namespace App\Providers;

use App\Models\Card;
use App\Policies\CardPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Card::class => CardPolicy::class,
    ];
}
