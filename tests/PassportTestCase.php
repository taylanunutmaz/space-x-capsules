<?php

namespace Tests;

use App\Models\User;
use DateTime;
use Laravel\Passport\ClientRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PassportTestCase extends TestCase
{
    use DatabaseTransactions;

    protected $headers = [];
    protected $user;

    /**
     * set up function to get JWT with passport and add headers Bearer Auth
     *
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPersonalAccessClient(
            null,
            'Test Personal Access Client',
            env('APP_URL')
        );

        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => $client->id,
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);

        $this->user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('example')
        ]);

        $token = $this->user->createToken('authToken')->accessToken;
        $this->headers['Accept'] = 'application/json';
        $this->headers['Authorization'] = 'Bearer '.$token;
    }
}
