<?php

namespace App\Listeners;

use App\Events\SyncCapsulesCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SyncCapsuleCompletedLog
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
     * @param  SyncCapsulesCompleted  $event
     * @return void
     */
    public function handle(SyncCapsulesCompleted $event)
    {
        Log::info('Sync Capsules from Space-X API process has completed. Data: '.json_encode($event->capsules));
    }
}
