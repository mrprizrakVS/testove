<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    public function testUserLoginSuccessfully()
    {
        $user = factory(User::class)->create([
            'email' => 'testlog@test.com',
            'password' => bcrypt('123456789'),
            'api_token' => str_random(60)
        ]);

        $payload = ['email' => 'testlog@test.com', 'password' => '123456789'];

        $this->json('POST', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'api_token',
                ],
            ]);

    }
}
