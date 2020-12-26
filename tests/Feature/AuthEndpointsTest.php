<?php

namespace Tests\Feature;

use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\PassportTestCase;

class AuthEndpointsTest extends PassportTestCase
{
    /**
     * Getting unauthenticated user.
     *
     * @return void
     */
    public function testGetUser()
    {
        $response = $this->getJson('/api/user');

        $response->assertStatus(401);
    }

    /**
     * Getting authenticated user.
     *
     * @return void
     */
    public function testGetUserWithUser()
    {
        $response = $this->getJson('/api/user', $this->headers);

        $response->assertStatus(200);
    }

    /**
     * Login to take JWT.
     *
     * @return void
     */
    public function testLogin()
    {
        $data = [
            'email' => 'user@example.com',
            'password' => 'example',
        ];

        $response = $this->postJson('/api/login', $data);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'user' => [
                'id',
                'name',
                'email',
                'created_at',
            ],
            'access_token',
        ]);
    }

    /**
     * Register.
     *
     * @return void
     */
    public function testRegister()
    {
        $data = [
            'name' => 'User2 Example',
            'email' => 'user2@example.com',
            'password' => 'example',
            'password_confirmation' => 'example',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'user' => [
                'id',
                'name',
                'email',
                'created_at',
            ],
            'access_token',
        ]);
        $response->assertJsonFragment([
            'name' => 'User2 Example',
            'email' => 'user2@example.com',
        ]);
    }
}
