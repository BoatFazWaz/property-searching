<?php

namespace Tests\Unit;

use App\Models\Property;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PropertyModelTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test property creation and attributes.
     */
    public function test_can_create_property(): void
    {
        $property = Property::create([
            'title' => '2 bedroom Condo for sale in Bangkok',
            'description' => 'A beautiful condo in the heart of Bangkok',
            'for_sale' => true,
            'for_rent' => false,
            'sold' => false,
            'price' => 500000,
            'currency' => 'THB',
            'currency_symbol' => '฿',
            'property_type' => 'Condo',
            'bedrooms' => 2,
            'bathrooms' => 1,
            'area' => 80,
            'area_type' => 'sqm',
            'country' => 'Thailand',
            'province' => 'Bangkok',
            'street' => '123 Sukhumvit Road',
            'photo_thumb' => 'https://example.com/thumb.jpg',
            'photo_search' => 'https://example.com/search.jpg',
            'photo_full' => 'https://example.com/full.jpg',
        ]);

        $this->assertInstanceOf(Property::class, $property);
        $this->assertEquals('2 bedroom Condo for sale in Bangkok', $property->title);
        $this->assertEquals('Bangkok', $property->province);
        $this->assertTrue($property->for_sale);
        $this->assertFalse($property->for_rent);
        $this->assertFalse($property->sold);
        $this->assertEquals(500000, $property->price);
        $this->assertEquals('Condo', $property->property_type);
        $this->assertEquals(2, $property->bedrooms);
    }

    /**
     * Test the available scope.
     */
    public function test_scope_available(): void
    {
        // Create sold property
        Property::create([
            'title' => 'Sold Property',
            'description' => 'This property is sold',
            'for_sale' => true,
            'for_rent' => false,
            'sold' => true,
            'price' => 500000,
            'currency' => 'THB',
            'currency_symbol' => '฿',
            'property_type' => 'Condo',
            'province' => 'Bangkok',
        ]);

        // Create available property
        Property::create([
            'title' => 'Available Property',
            'description' => 'This property is available',
            'for_sale' => true,
            'for_rent' => false,
            'sold' => false,
            'price' => 600000,
            'currency' => 'THB',
            'currency_symbol' => '฿',
            'property_type' => 'House',
            'province' => 'Phuket',
        ]);

        $availableProperties = Property::available()->get();
        
        $this->assertEquals(1, $availableProperties->count());
        $this->assertEquals('Available Property', $availableProperties->first()->title);
    }

    /**
     * Test the forSale scope.
     */
    public function test_scope_for_sale(): void
    {
        // Create property for sale
        Property::create([
            'title' => 'For Sale Property',
            'description' => 'This property is for sale',
            'for_sale' => true,
            'for_rent' => false,
            'sold' => false,
            'price' => 500000,
            'currency' => 'THB',
            'currency_symbol' => '฿',
            'property_type' => 'Condo',
            'province' => 'Bangkok',
        ]);

        // Create property for rent
        Property::create([
            'title' => 'For Rent Property',
            'description' => 'This property is for rent',
            'for_sale' => false,
            'for_rent' => true,
            'sold' => false,
            'price' => 20000,
            'currency' => 'THB',
            'currency_symbol' => '฿',
            'property_type' => 'House',
            'province' => 'Phuket',
        ]);

        $forSaleProperties = Property::forSale()->get();
        
        $this->assertEquals(1, $forSaleProperties->count());
        $this->assertEquals('For Sale Property', $forSaleProperties->first()->title);
    }

    /**
     * Test the forRent scope.
     */
    public function test_scope_for_rent(): void
    {
        // Create property for sale
        Property::create([
            'title' => 'For Sale Property',
            'description' => 'This property is for sale',
            'for_sale' => true,
            'for_rent' => false,
            'sold' => false,
            'price' => 500000,
            'currency' => 'THB',
            'currency_symbol' => '฿',
            'property_type' => 'Condo',
            'province' => 'Bangkok',
        ]);

        // Create property for rent
        Property::create([
            'title' => 'For Rent Property',
            'description' => 'This property is for rent',
            'for_sale' => false,
            'for_rent' => true,
            'sold' => false,
            'price' => 20000,
            'currency' => 'THB',
            'currency_symbol' => '฿',
            'property_type' => 'House',
            'province' => 'Phuket',
        ]);

        $forRentProperties = Property::forRent()->get();
        
        $this->assertEquals(1, $forRentProperties->count());
        $this->assertEquals('For Rent Property', $forRentProperties->first()->title);
    }

    /**
     * Test the byProvince scope.
     */
    public function test_scope_by_province(): void
    {
        // Create property in Bangkok
        Property::create([
            'title' => 'Bangkok Property',
            'description' => 'This property is in Bangkok',
            'for_sale' => true,
            'for_rent' => false,
            'sold' => false,
            'price' => 500000,
            'currency' => 'THB',
            'currency_symbol' => '฿',
            'property_type' => 'Condo',
            'province' => 'Bangkok',
        ]);

        // Create property in Phuket
        Property::create([
            'title' => 'Phuket Property',
            'description' => 'This property is in Phuket',
            'for_sale' => true,
            'for_rent' => false,
            'sold' => false,
            'price' => 600000,
            'currency' => 'THB',
            'currency_symbol' => '฿',
            'property_type' => 'Villa',
            'province' => 'Phuket',
        ]);

        $bangkokProperties = Property::byProvince('Bangkok')->get();
        
        $this->assertEquals(1, $bangkokProperties->count());
        $this->assertEquals('Bangkok Property', $bangkokProperties->first()->title);
    }

    /**
     * Test the search scope.
     */
    public function test_scope_search(): void
    {
        // Create properties with different titles
        Property::create([
            'title' => 'Luxury Condo in Bangkok',
            'description' => 'A beautiful condo in the heart of Bangkok',
            'for_sale' => true,
            'for_rent' => false,
            'sold' => false,
            'price' => 500000,
            'currency' => 'THB',
            'currency_symbol' => '฿',
            'property_type' => 'Condo',
            'province' => 'Bangkok',
        ]);

        Property::create([
            'title' => 'Beach Villa Phuket',
            'description' => 'Beachfront villa with amazing views',
            'for_sale' => true,
            'for_rent' => false,
            'sold' => false,
            'price' => 800000,
            'currency' => 'THB',
            'currency_symbol' => '฿',
            'property_type' => 'Villa',
            'province' => 'Phuket',
        ]);

        // Test search by title
        $luxuryProperties = Property::search('Luxury')->get();
        $this->assertEquals(1, $luxuryProperties->count());
        $this->assertEquals('Luxury Condo in Bangkok', $luxuryProperties->first()->title);

        // Test search by province
        $phuketProperties = Property::search('Phuket')->get();
        $this->assertEquals(1, $phuketProperties->count());
        $this->assertEquals('Beach Villa Phuket', $phuketProperties->first()->title);
    }

    /**
     * Test combining multiple scopes.
     */
    public function test_combining_scopes(): void
    {
        // Create various properties
        Property::create([
            'title' => 'Luxury Condo in Bangkok for sale',
            'for_sale' => true,
            'for_rent' => false,
            'sold' => false,
            'price' => 500000,
            'property_type' => 'Condo',
            'province' => 'Bangkok',
        ]);

        Property::create([
            'title' => 'Apartment in Bangkok for rent',
            'for_sale' => false,
            'for_rent' => true,
            'sold' => false,
            'price' => 15000,
            'property_type' => 'Apartment',
            'province' => 'Bangkok',
        ]);

        Property::create([
            'title' => 'Sold Villa in Phuket',
            'for_sale' => true,
            'for_rent' => false,
            'sold' => true,
            'price' => 900000,
            'property_type' => 'Villa',
            'province' => 'Phuket',
        ]);

        // Test combining forSale, available, and byProvince scopes
        $bangkokAvailableForSale = Property::forSale()->available()->byProvince('Bangkok')->get();
        
        $this->assertEquals(1, $bangkokAvailableForSale->count());
        $this->assertEquals('Luxury Condo in Bangkok for sale', $bangkokAvailableForSale->first()->title);
    }
} 