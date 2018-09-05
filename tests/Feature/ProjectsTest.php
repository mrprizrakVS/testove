<?php

namespace Tests\Feature;

use App\Models\Projects;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectsTest extends TestCase
{
    public function testProjectsAreCreatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $filled = [
            'name' => 'Name Project',
            'description' => 'Description',
            'statuses' => 2,
        ];

        $this->json('POST', '/api/projects/store', $filled, $headers)
            ->assertStatus(201)
            ->assertJson([
                'name' => 'Name Project',
                'description' => 'Description',
                'statuses' => 2,
            ]);
    }

    public function testProjectsAreUpdateCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $client = factory(Projects::class)->create();

        $update = [
            'name' => 'Name Project',
            'description' => 'Description',
            'statuses' => 2,
        ];

        $this->json('PUT', '/api/projects/update/' . $client->id, $update, $headers)
            ->assertStatus(200)
            ->assertJson([
                'name' => 'Name Project',
                'description' => 'Description',
                'statuses' => 2,
            ]);
    }

    public function testsProjectsAreDeletedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $client = factory(Projects::class)->create();

        $this->json('DELETE', '/api/projects/delete/' . $client->id, [], $headers)
            ->assertStatus(204);
    }

    public function testProjectsAreListedCorrectly()
    {
        factory(Projects::class)->create();

        factory(Projects::class)->create();

        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', '/api/projects', [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'name', 'description', 'statuses', 'created_at', 'updated_at'],
            ]);
    }
}
