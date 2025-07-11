<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        try {
            $departments = Department::all();
            return response()->json($departments);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving departments', 'error' => $e->getMessage()], 500);
        }
    }
}
