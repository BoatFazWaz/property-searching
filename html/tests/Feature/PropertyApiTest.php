<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Property;

class PropertyApiTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test properties
        $this->createTestProperties();
    }
    
    /**
     * Create test properties for testing.
     */
    private function createTestProperties()
    {
        // Create 25 properties that are for sale and not sold (to meet pagination requirement)
        for ($i = 0; $i < 25; $i++) {
            Property::create([
                'title' => $this->faker->randomElement([
                    '1 bedroom', '2 bedroom', '3 bedroom', '4 bedroom', '5 bedroom'
                ]) . ' ' . $this->faker->randomElement([
                    'Condo', 'Apartment', 'House', 'Villa', 'Townhouse'
                ]) . ' for sale in ' . $this->faker->randomElement([
                    'Bangkok', 'Phuket', 'Chiang Mai', 'Pattaya', 'Samut Prakan', 'Chon Buri'
                ]),
                'description' => $this->faker->paragraph,
                'for_sale' => true,
                'for_rent' => false,
                'sold' => false,
                'price' => $this->faker->numberBetween(100000, 1000000),
                'currency' => 'THB',
                'currency_symbol' => '฿',
                'property_type' => $this->faker->randomElement([
                    'Condo', 'Apartment', 'House', 'Villa', 'Townhouse'
                ]),
                'bedrooms' => $this->faker->numberBetween(1, 5),
                'bathrooms' => $this->faker->numberBetween(1, 5),
                'area' => $this->faker->numberBetween(30, 200),
                'area_type' => 'sqm',
                'country' => 'Thailand',
                'province' => $this->faker->randomElement([
                    'Bangkok', 'Phuket', 'Chiang Mai', 'Pattaya', 'Samut Prakan', 'Chon Buri'
                ]),
                'street' => $this->faker->streetAddress,
                'photo_thumb' => 'https://placehold.co/150x100',
                'photo_search' => 'https://placehold.co/300x150',
                'photo_full' => 'https://placehold.co/600x300',
            ]);
        }
        
        // Create 5 additional properties with different statuses (for variety in testing)
        for ($i = 0; $i < 5; $i++) {
            $forSale = $i % 2 == 0;
            $forRent = !$forSale;
            $sold = $i == 4; // Make the last one sold
            
            Property::create([
                'title' => $this->faker->randomElement([
                    '1 bedroom', '2 bedroom', '3 bedroom', '4 bedroom', '5 bedroom'
                ]) . ' ' . $this->faker->randomElement([
                    'Condo', 'Apartment', 'House', 'Villa', 'Townhouse'
                ]) . ' for ' . ($forSale ? 'sale' : 'rent') . ' in ' . $this->faker->randomElement([
                    'Bangkok', 'Phuket', 'Chiang Mai', 'Pattaya', 'Samut Prakan', 'Chon Buri'
                ]),
                'description' => $this->faker->paragraph,
                'for_sale' => $forSale,
                'for_rent' => $forRent,
                'sold' => $sold,
                'price' => $this->faker->numberBetween(100000, 1000000),
                'currency' => 'THB',
                'currency_symbol' => '฿',
                'property_type' => $this->faker->randomElement([
                    'Condo', 'Apartment', 'House', 'Villa', 'Townhouse'
                ]),
                'bedrooms' => $this->faker->numberBetween(1, 5),
                'bathrooms' => $this->faker->numberBetween(1, 5),
                'area' => $this->faker->numberBetween(30, 200),
                'area_type' => 'sqm',
                'country' => 'Thailand',
                'province' => $this->faker->randomElement([
                    'Bangkok', 'Phuket', 'Chiang Mai', 'Pattaya', 'Samut Prakan', 'Chon Buri'
                ]),
                'street' => $this->faker->streetAddress,
                'photo_thumb' => 'https://placehold.co/150x100',
                'photo_search' => 'https://placehold.co/300x150',
                'photo_full' => 'https://placehold.co/600x300',
            ]);
        }
    }

    /**
     * Test getting a list of properties.
     */
    public function test_get_properties_list(): void
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
                    'property_type',
                    'bedrooms',
                    'bathrooms',
                    'province'
                ]
            ],
            'current_page',
            'per_page',
            'total'
        ]);

        // Ensure we get 25 items per page (pagination)
        $response->assertJsonCount(25, 'data');
    }

    /**
     * Test filtering properties by province.
     */
    public function test_filter_properties_by_province(): void
    {
        // Get a province with properties
        $property = Property::first();
        $province = $property->province;

        $response = $this->get("/api/properties?province={$province}");

        $response->assertStatus(200);
        
        // If there are results, ensure all returned properties are from the filtered province
        $responseData = $response->json('data');
        if (count($responseData) > 0) {
            $this->assertEquals($province, $responseData[0]['province']);
            foreach ($responseData as $property) {
                $this->assertEquals($province, $property['province']);
            }
        }
    }

    /**
     * Test search functionality for properties.
     */
    public function test_search_properties(): void
    {
        // Get a property to search for
        $property = Property::first();
        $searchTerm = explode(' ', $property->title)[0]; // Use first word of title

        $response = $this->get("/api/properties?search={$searchTerm}");

        $response->assertStatus(200);
    }

    /**
     * Test sorting properties by price ascending.
     */
    public function test_sort_properties_by_price_asc(): void
    {
        $response = $this->get('/api/properties?sort_by=price&sort_direction=asc');

        $response->assertStatus(200);
        
        $properties = $response->json('data');
        if (count($properties) > 1) {
            // Check if properties are sorted by price in ascending order
            $this->assertLessThanOrEqual(
                $properties[1]['price'],
                $properties[0]['price']
            );
        }
    }

    /**
     * Test sorting properties by price descending.
     */
    public function test_sort_properties_by_price_desc(): void
    {
        $response = $this->get('/api/properties?sort_by=price&sort_direction=desc');

        $response->assertStatus(200);
        
        $properties = $response->json('data');
        if (count($properties) > 1) {
            // Check if properties are sorted by price in descending order
            $this->assertGreaterThanOrEqual(
                $properties[1]['price'],
                $properties[0]['price']
            );
        }
    }

    /**
     * Test sorting properties by date (newest first).
     */
    public function test_sort_properties_by_date_newest_first(): void
    {
        $response = $this->get('/api/properties?sort_by=created_at&sort_direction=desc');

        $response->assertStatus(200);
    }

    /**
     * Test getting a list of provinces.
     */
    public function test_get_provinces_list(): void
    {
        $response = $this->get('/api/properties/provinces');

        $response->assertStatus(200);
        $this->assertIsArray($response->json());
        $this->assertNotEmpty($response->json());
    }

    /**
     * Test getting a list of property types.
     */
    public function test_get_property_types(): void
    {
        $response = $this->get('/api/properties/types');

        $response->assertStatus(200);
        $this->assertIsArray($response->json());
        $this->assertNotEmpty($response->json());
    }

    /**
     * Test filtering for sale properties.
     */
    public function test_filter_for_sale_properties(): void
    {
        $response = $this->get('/api/properties?for_sale=1');

        $response->assertStatus(200);
        
        $properties = $response->json('data');
        if (!empty($properties)) {
            foreach ($properties as $property) {
                $this->assertTrue($property['for_sale']);
            }
        }
    }

    /**
     * Test error handling for invalid search queries.
     */
    public function test_invalid_search_query_returns_empty_results(): void
    {
        $response = $this->get('/api/properties?search=xyznonexistentproperty123');

        $response->assertStatus(200);
        $this->assertEmpty($response->json('data'));
    }
}
