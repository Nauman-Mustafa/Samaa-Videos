<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        try {
            $locations = Location::all();
            return response()->json($locations);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving locations', 'error' => $e->getMessage()], 500);
        }
    }
}
