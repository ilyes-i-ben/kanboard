<?php

namespace App\Providers;

use App\Listeners\SendDeferredBoardInvitations;
use App\Listeners\SendWelcomeNotification;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Support\Providers;

// TODO: email being sent twice ??
class EventServiceProvider extends Providers\EventServiceProvider
{
    protected $listen = [
        Verified::class => [
            SendWelcomeNotification::class,
            SendDeferredBoardInvitations::class,
        ],
    ];
    protected static $shouldDiscoverEvents = false;

    // turning off event auto discovery to confirm listerenrs order.
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
