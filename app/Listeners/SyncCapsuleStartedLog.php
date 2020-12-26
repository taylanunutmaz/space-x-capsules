<?php

namespace App\Listeners;

use App\Events\SyncCapsulesStarted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SyncCapsuleStartedLog
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SyncCapsulesStarted  $event
     * @return void
     */
    public function handle(SyncCapsulesStarted $event)
    {
        Log::info('Sync Capsules from Space-X API process has started.');
    }
}
