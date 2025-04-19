<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display the properties view.
     * This is the main entry point for the SPA.
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Check if a province exists and return 404 if not.
     */
    public function showProvince($province)
    {
        // Check if the province exists
        $exists = Property::where('province', $province)->exists();
        
        if (!$exists) {
            abort(404);
        }
        
        return view('welcome');
    }
}
