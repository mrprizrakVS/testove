<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LogoutUserTest extends TestCase
{
    public function testUserIsLoggedOutProperly()
    {
        $user = factory(User::class)->create(['email' => 'user@test.com']);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('get', '/api/clients', [], $headers)->assertStatus(200);
        $this->json('post', '/api/logout', [], $headers)->assertStatus(200);

        $user = User::find($user->id);

        $this->assertEquals(null, $user->api_token);
    }

    public function testUserWithNullToken()
    {
        $user = factory(User::class)->create(['email' => 'user2@test2.com']);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $user->api_token = null;
        $user->save();

        $this->json('get', '/api/projects', [], $headers)->assertStatus(401);
    }
}
