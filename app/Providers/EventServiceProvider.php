<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\SyncCapsulesStarted;
use App\Events\SyncCapsulesCompleted;
use App\Listeners\SyncCapsuleStartedLog;
use App\Listeners\SyncCapsuleCompletedLog;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SyncCapsulesStarted::class => [
            SyncCapsuleStartedLog::class,
        ],
        SyncCapsulesCompleted::class => [
            SyncCapsuleCompletedLog::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
