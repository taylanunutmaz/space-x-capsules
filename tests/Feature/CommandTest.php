<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommandTest extends TestCase
{
    /**
     * Command Test for SyncSpaceXCapsulesData.
     *
     * @return void
     */
    public function testSyncSpaceXCapsulesData()
    {
        $this->artisan('space-x:sync-capsule-data')
            ->expectsOutput('Getting capsule data.')
            ->expectsOutput('Syncing capsule data.')
            ->assertExitCode(0);
    }
}
