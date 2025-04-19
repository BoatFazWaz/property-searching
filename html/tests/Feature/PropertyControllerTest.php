<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Property;

class PropertyControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test that the index method returns the welcome view.
     */
    public function test_index_returns_welcome_view(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('welcome');
    }

    /**
     * Test that the showProvince method returns the welcome view when province exists.
     */
    public function test_show_province_returns_welcome_view_when_province_exists(): void
    {
        Property::create([
            'title' => 'Test Property',
            'description' => 'Test description',
            'for_sale' => true,
            'for_rent' => false,
            'sold' => false,
            'price' => 500000,
            'province' => 'Bangkok',
            'property_type' => 'Condo',
        ]);

        $response = $this->get('/Bangkok');

        $response->assertStatus(200);
        $response->assertViewIs('welcome');
    }

    /**
     * Test that the showProvince method returns 404 when province does not exist.
     */
    public function test_show_province_returns_404_when_province_does_not_exist(): void
    {
        $response = $this->get('/NonExistentProvince');

        $response->assertStatus(404);
    }
} 