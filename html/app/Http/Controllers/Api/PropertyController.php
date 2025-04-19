<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of properties with filters and search.
     */
    public function index(Request $request)
    {
        $query = Property::query();

        // Apply filters
        if ($request->has('type')) {
            $query->where('property_type', $request->type);
        }

        if ($request->has('province')) {
            $query->byProvince($request->province);
        }

        if ($request->has('search')) {
            $query->search($request->search);
        }

        if ($request->has('for_sale')) {
            $query->forSale();
        }

        if ($request->has('for_rent')) {
            $query->forRent();
        }

        // Only show available (unsold) properties by default
        if (!$request->has('include_sold')) {
            $query->available();
        }

        // Apply sorting
        $sortField = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        
        if (in_array($sortField, ['price', 'created_at'])) {
            $query->orderBy($sortField, $sortDirection === 'asc' ? 'asc' : 'desc');
        }

        // Paginate results
        return $query->paginate(25);
    }

    /**
     * Get a list of all provinces.
     */
    public function provinces()
    {
        return Property::select('province')
            ->distinct()
            ->orderBy('province')
            ->pluck('province');
    }

    /**
     * Get a list of all property types.
     */
    public function types()
    {
        return Property::select('property_type')
            ->distinct()
            ->orderBy('property_type')
            ->pluck('property_type');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
