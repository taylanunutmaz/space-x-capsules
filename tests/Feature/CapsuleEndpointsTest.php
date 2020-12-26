<?php

namespace Tests\Feature;

use App\Models\Capsule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Tests\PassportTestCase;

class CapsuleEndpointsTest extends PassportTestCase
{
    /**
     * List capsules unauthenticated.
     *
     * @return void
     */
    public function testListCapsules()
    {
        $response = $this->getJson('/api/capsules');
        $response->assertStatus(401);
        $response->assertJson(['message' => "Unauthenticated."]);
    }

    /**
     * List capsules with authenticated user.
     *
     * @return void
     */
    public function testListCapsulesWithUser()
    {
        $response = $this->getJson('/api/capsules', $this->headers);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'capsule_serial',
                    'capsule_id',
                    'status',
                    'original_launch',
                    'original_launch_unix',
                    'landings',
                    'details',
                    'reuse_count',
                    'missions' => [
                        '*' => [
                            'name',
                            'flight',
                        ],
                    ],
                ],
            ],
        ]);
    }

    /**
     * List capsules with status filter and authenticated user.
     *
     * @return void
     */
    public function testListCapsulesWithStatusFilterAndUser()
    {
        $capsule_statuses = Capsule::all()->pluck('status');

        foreach ($capsule_statuses as $status) {
            $response = $this->json('GET', '/api/capsules', ['status' => $status], $this->headers);

            $response->assertStatus(200);
            $response->assertJsonFragment(['status' => $status]);
            $response->assertJsonStructure([
                'data' => [
                    '*' => [
                        'capsule_serial',
                        'capsule_id',
                        'status',
                        'original_launch',
                        'original_launch_unix',
                        'landings',
                        'details',
                        'reuse_count',
                        'missions' => [
                            '*' => [
                                'name',
                                'flight',
                            ],
                        ],
                    ],
                ],
            ]);
        }
    }

    /**
     * Show specific capsule with unauthenticated user.
     *
     * @return void
     */
    public function testShowCapsule()
    {
        $capsule_serial = Capsule::inRandomOrder()->first()->capsule_serial;

        $response = $this->getJson("/api/capsules/{$capsule_serial}");
        $response->assertStatus(401);
        $response->assertJson(['message' => "Unauthenticated."]);
    }

    /**
     * Show specific capsule with authenticated user.
     *
     * @return void
     */
    public function testShowCapsulesWithUser()
    {
        $this->WithoutMiddleware();
        $capsule_serial = Capsule::inRandomOrder()->first()->capsule_serial;

        $response = $this->getJson("/api/capsules/{$capsule_serial}", $this->headers);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'capsule_serial',
                'capsule_id',
                'status',
                'original_launch',
                'original_launch_unix',
                'landings',
                'details',
                'reuse_count',
                'missions' => [
                    '*' => [
                        'name',
                        'flight',
                    ],
                ],
            ],
        ]);
    }
}
