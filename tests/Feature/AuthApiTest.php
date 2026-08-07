<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\DatabaseSeeder;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_admin_can_login_with_valid_credentials(): void
    {
        $response = $this->postJson('/api/admin/login', [
            'email' => 'admin@coopesq.com.br',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token', 'user' => ['id', 'name', 'email', 'role']]);
    }

    public function test_admin_cannot_login_with_invalid_credentials(): void
    {
        $response = $this->postJson('/api/admin/login', [
            'email' => 'admin@coopesq.com.br',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(422);
    }
}
