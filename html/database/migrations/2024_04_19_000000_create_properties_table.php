<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->boolean('for_sale')->default(false);
            $table->boolean('for_rent')->default(false);
            $table->boolean('sold')->default(false);
            $table->decimal('price', 12, 2);
            $table->string('currency', 3)->default('THB');
            $table->string('currency_symbol', 10)->default('฿');
            $table->string('property_type');
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->decimal('area', 10, 2);
            $table->string('area_type', 10)->default('sqm');
            
            // Geo information
            $table->string('country');
            $table->string('province');
            $table->string('street');
            
            // Photo URLs
            $table->string('photo_thumb')->nullable();
            $table->string('photo_search')->nullable();
            $table->string('photo_full')->nullable();
            
            $table->timestamps();
            
            // Add indexes for commonly searched fields
            $table->index('title');
            $table->index('property_type');
            $table->index('province');
            $table->index(['for_sale', 'sold']);
            $table->index(['for_rent', 'sold']);
            $table->index('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
}; 