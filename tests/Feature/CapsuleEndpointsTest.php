<?php

namespace Tests\Feature;

use App\Models\Capsule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class CapsuleEndpointsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testListCapsules()
    {
        $response = $this->json('GET', '/api/capsules');
        $response->assertStatus(401);
        $response->assertJson(['message' => "Unauthenticated."]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testListCapsulesWithoutMiddleware()
    {
        $this->WithoutMiddleware();

        $response = $this->json('GET', '/api/capsules');
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
     * A basic feature test example.
     *
     * @return void
     */
    public function testListCapsulesWithStatusFilterWithoutMiddleware()
    {
        $this->WithoutMiddleware();

        $capsule_statuses = Capsule::all()->pluck('status');

        foreach ($capsule_statuses as $status) {
            $response = $this->json('GET', '/api/capsules', ['status' => $status]);

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
     * A basic feature test example.
     *
     * @return void
     */
    public function testShowCapsule()
    {
        $capsule_serial = Capsule::inRandomOrder()->first()->capsule_serial;

        $response = $this->json('GET', "/api/capsules/{$capsule_serial}");
        $response->assertStatus(401);
        $response->assertJson(['message' => "Unauthenticated."]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testShowCapsulesWithoutMiddleware()
    {
        $this->WithoutMiddleware();
        $capsule_serial = Capsule::inRandomOrder()->first()->capsule_serial;

        $response = $this->json('GET', "/api/capsules/{$capsule_serial}");
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
