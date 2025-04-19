<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Property;

class ApiPropertyControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Setup test data.
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a diverse set of properties for testing
        $this->createTestProperties();
    }

    /**
     * Create test properties
     */
    private function createTestProperties(): void
    {
        // Properties for sale (not sold)
        Property::create([
            'title' => 'Luxury Condo in Bangkok',
            'description' => 'A beautiful luxury condo with pool access',
            'for_sale' => true,
            'for_rent' => false,
            'sold' => false,
            'price' => 5000000,
            'currency' => 'THB',
            'currency_symbol' => '฿',
            'property_type' => 'Condo',
            'bedrooms' => 2,
            'bathrooms' => 2,
            'area' => 80,
            'area_type' => 'sqm',
            'country' => 'Thailand',
            'province' => 'Bangkok',
            'street' => '123 Sukhumvit Road',
        ]);

        Property::create([
            'title' => 'Beach Villa in Phuket',
            'description' => 'Stunning beachfront villa with private pool',
            'for_sale' => true,
            'for_rent' => false,
            'sold' => false,
            'price' => 12000000,
            'currency' => 'THB',
            'currency_symbol' => '฿',
            'property_type' => 'Villa',
            'bedrooms' => 4,
            'bathrooms' => 5,
            'area' => 350,
            'area_type' => 'sqm',
            'country' => 'Thailand',
            'province' => 'Phuket',
            'street' => '45 Beach Road',
        ]);

        // Property for rent
        Property::create([
            'title' => 'Modern Apartment for rent',
            'description' => 'Fully furnished modern apartment in city center',
            'for_sale' => false,
            'for_rent' => true,
            'sold' => false,
            'price' => 25000,
            'currency' => 'THB',
            'currency_symbol' => '฿',
            'property_type' => 'Apartment',
            'bedrooms' => 1,
            'bathrooms' => 1,
            'area' => 55,
            'area_type' => 'sqm',
            'country' => 'Thailand',
            'province' => 'Chiang Mai',
            'street' => '67 Nimman Road',
        ]);

        // Sold property
        Property::create([
            'title' => 'Townhouse in Bangkok (SOLD)',
            'description' => 'Recently renovated townhouse in quiet neighborhood',
            'for_sale' => true,
            'for_rent' => false,
            'sold' => true,
            'price' => 4200000,
            'currency' => 'THB',
            'currency_symbol' => '฿',
            'property_type' => 'Townhouse',
            'bedrooms' => 3,
            'bathrooms' => 3,
            'area' => 150,
            'area_type' => 'sqm',
            'country' => 'Thailand',
            'province' => 'Bangkok',
            'street' => '89 Silom Road',
        ]);
    }

    /**
     * Test the index method with no filters.
     */
    public function test_index_with_no_filters(): void
    {
        $response = $this->get('/api/properties');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'description',
                    'for_sale',
                    'for_rent',
                    'sold',
                    'price',
                    'currency',
                    'currency_symbol',
                    'property_type',
                    'bedrooms',
                    'bathrooms',
                    'area',
                    'area_type',
                    'country',
                    'province',
                    'street',
                ]
            ],
            'current_page',
            'per_page',
            'total'
        ]);

        // By default, sold properties should be excluded
        $data = $response->json('data');
        foreach ($data as $property) {
            $this->assertFalse($property['sold']);
        }
    }

    /**
     * Test filtering properties by type.
     */
    public function test_filter_by_type(): void
    {
        $response = $this->get('/api/properties?type=Villa');

        $response->assertStatus(200);
        
        $data = $response->json('data');
        foreach ($data as $property) {
            $this->assertEquals('Villa', $property['property_type']);
        }
    }

    /**
     * Test filtering properties by province.
     */
    public function test_filter_by_province(): void
    {
        $response = $this->get('/api/properties?province=Bangkok');

        $response->assertStatus(200);
        
        $data = $response->json('data');
        foreach ($data as $property) {
            $this->assertEquals('Bangkok', $property['province']);
        }
    }

    /**
     * Test searching properties.
     */
    public function test_search_properties(): void
    {
        $response = $this->get('/api/properties?search=Luxury');

        $response->assertStatus(200);
        
        $data = $response->json('data');
        $this->assertNotEmpty($data);
        
        // Check if the search term is in the title
        $foundMatch = false;
        foreach ($data as $property) {
            if (strpos($property['title'], 'Luxury') !== false) {
                $foundMatch = true;
                break;
            }
        }
        $this->assertTrue($foundMatch);
    }

    /**
     * Test filtering for sale properties.
     */
    public function test_filter_for_sale_properties(): void
    {
        $response = $this->get('/api/properties?for_sale=1');

        $response->assertStatus(200);
        
        $data = $response->json('data');
        foreach ($data as $property) {
            $this->assertTrue($property['for_sale']);
        }
    }

    /**
     * Test filtering for rent properties.
     */
    public function test_filter_for_rent_properties(): void
    {
        $response = $this->get('/api/properties?for_rent=1');

        $response->assertStatus(200);
        
        $data = $response->json('data');
        foreach ($data as $property) {
            $this->assertTrue($property['for_rent']);
        }
    }

    /**
     * Test including sold properties.
     */
    public function test_include_sold_properties(): void
    {
        $response = $this->get('/api/properties?include_sold=1');

        $response->assertStatus(200);
        
        // Check if any sold properties are included in the response
        $data = $response->json('data');
        $foundSold = false;
        foreach ($data as $property) {
            if ($property['sold']) {
                $foundSold = true;
                break;
            }
        }
        $this->assertTrue($foundSold);
    }

    /**
     * Test sorting by price ascending.
     */
    public function test_sort_by_price_ascending(): void
    {
        $response = $this->get('/api/properties?sort_by=price&sort_direction=asc');

        $response->assertStatus(200);
        
        $data = $response->json('data');
        if (count($data) > 1) {
            $this->assertLessThanOrEqual($data[1]['price'], $data[0]['price']);
        }
    }

    /**
     * Test sorting by price descending.
     */
    public function test_sort_by_price_descending(): void
    {
        $response = $this->get('/api/properties?sort_by=price&sort_direction=desc');

        $response->assertStatus(200);
        
        $data = $response->json('data');
        if (count($data) > 1) {
            $this->assertGreaterThanOrEqual($data[1]['price'], $data[0]['price']);
        }
    }

    /**
     * Test provinces endpoint.
     */
    public function test_get_provinces(): void
    {
        $response = $this->get('/api/properties/provinces');

        $response->assertStatus(200);
        $this->assertIsArray($response->json());
        $this->assertContains('Bangkok', $response->json());
        $this->assertContains('Phuket', $response->json());
        $this->assertContains('Chiang Mai', $response->json());
    }

    /**
     * Test property types endpoint.
     */
    public function test_get_property_types(): void
    {
        $response = $this->get('/api/properties/types');

        $response->assertStatus(200);
        $this->assertIsArray($response->json());
        $this->assertContains('Condo', $response->json());
        $this->assertContains('Villa', $response->json());
        $this->assertContains('Apartment', $response->json());
        $this->assertContains('Townhouse', $response->json());
    }

    /**
     * Test combining multiple filters.
     */
    public function test_combining_multiple_filters(): void
    {
        $response = $this->get('/api/properties?province=Bangkok&for_sale=1&sort_by=price&sort_direction=desc');

        $response->assertStatus(200);
        
        $data = $response->json('data');
        foreach ($data as $property) {
            $this->assertEquals('Bangkok', $property['province']);
            $this->assertTrue($property['for_sale']);
        }
        
        if (count($data) > 1) {
            $this->assertGreaterThanOrEqual($data[1]['price'], $data[0]['price']);
        }
    }
} 