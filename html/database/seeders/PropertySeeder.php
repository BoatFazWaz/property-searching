<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(base_path('../properties.json'));
        $properties = json_decode($json);

        foreach ($properties as $property) {
            Property::create([
                'title' => $property->title,
                'description' => $property->description,
                'for_sale' => $property->for_sale,
                'for_rent' => $property->for_rent,
                'sold' => $property->sold,
                'price' => $property->price,
                'currency' => $property->currency,
                'currency_symbol' => $property->currency_symbol,
                'property_type' => $property->property_type,
                'bedrooms' => $property->bedrooms,
                'bathrooms' => $property->bathrooms,
                'area' => $property->area,
                'area_type' => $property->area_type,
                'country' => $property->geo->country,
                'province' => $property->geo->province,
                'street' => $property->geo->street,
                'photo_thumb' => $property->photos->thumb,
                'photo_search' => $property->photos->search,
                'photo_full' => $property->photos->full,
            ]);
        }
    }
}
