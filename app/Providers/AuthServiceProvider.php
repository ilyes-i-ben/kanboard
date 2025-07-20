<?php

namespace App\Providers;

use App\Models\Card;
use App\Models\ListModel;
use App\Policies\CardPolicy;
use App\Policies\ListModelPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Card::class => CardPolicy::class,
        ListModel::class => ListModelPolicy::class,
    ];
}
