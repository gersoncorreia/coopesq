<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\DatabaseSeeder;

class PublicApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_can_fetch_whitelabel_settings(): void
    {
        $response = $this->getJson('/api/settings');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'general' => ['site_name', 'mission', 'vision', 'values'],
                'contacts' => ['phone_primary', 'email', 'address'],
                'socials' => ['instagram'],
                'seo' => ['meta_title', 'meta_description'],
            ])
            ->assertJsonFragment([
                'email' => 'coopesqcooperativa@gmail.com',
                'address' => 'Porto Acre - AC, Brasil',
            ]);
    }

    public function test_can_fetch_products_catalog(): void
    {
        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
            ->assertJsonPath('total', 14);
    }

    public function test_can_fetch_partners(): void
    {
        $response = $this->getJson('/api/partners');

        $response->assertStatus(200)
            ->assertJsonCount(12);
    }
}
