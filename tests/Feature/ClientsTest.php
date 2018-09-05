<?php

namespace Tests\Feature;

use \App\Models\Clients;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ClientsTest extends TestCase
{
    public function testClientsAreCreatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $filled = [
            'first_name' => 'Nikolya',
            'last_name' => 'Last Name',
            'email' => 'nikolya@test.com',
            'password' => '1234567890',
        ];

        $this->json('POST', '/api/clients/store', $filled, $headers)
            ->assertStatus(201)
            ->assertJson([
                'first_name' => 'Nikolya',
                'last_name' => 'Last Name',
                'email' => 'nikolya@test.com',
                'password' => '1234567890',
            ]);
    }

    public function testClientsAreUpdateCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $client = factory(Clients::class)->create();

        $update = [
            'first_name' => 'Nikolya22',
            'last_name' => 'Last Name22',
            'email' => 'nikoly222a@test.com',
            'password' => '123412414125wfasdgf132rf567890',
        ];

        $this->json('PUT', '/api/clients/update/' . $client->id, $update, $headers)
            ->assertStatus(200)
            ->assertJson([
                'first_name' => 'Nikolya22',
                'last_name' => 'Last Name22',
                'email' => 'nikoly222a@test.com',
                'password' => '123412414125wfasdgf132rf567890',
            ]);
    }

    public function testsClientsAreDeletedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $client = factory(Clients::class)->create();

        $this->json('DELETE', '/api/clients/delete/' . $client->id, [], $headers)
            ->assertStatus(204);
    }

    public function testClientsAreListedCorrectly()
    {
        factory(Clients::class)->create();

        factory(Clients::class)->create();

        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', '/api/clients', [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'first_name', 'last_name', 'email', 'password', 'created_at', 'updated_at'],
            ]);
    }
}
