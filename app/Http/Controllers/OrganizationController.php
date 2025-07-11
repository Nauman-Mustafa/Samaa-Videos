<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Department;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class OrganizationController extends Controller
{
    public function index()
    {
        return Organization::with(['departments', 'locations'])
            ->withCount('assets')
            ->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:organizations,name'
        ]);

        $organization = Organization::create($validated);
        return $organization->load(['departments', 'locations']);
    }

    public function show(Organization $organization)
    {
        return $organization->load(['departments', 'locations']);
    }

    public function update(Request $request, Organization $organization)
    {
        $validated = $request->validate([
            'name' => 'required|unique:organizations,name,' . $organization->id
        ]);

        $organization->update($validated);
        return $organization->load(['departments', 'locations']);
    }

    public function destroy(Organization $organization)
    {
        if ($organization->assets()->count() > 0) {
            return response()->json([
                'message' => 'Cannot delete organization with associated assets'
            ], 422);
        }

        $organization->delete();
        return response()->json(['message' => 'Organization deleted successfully']);
    }

    /**
     * Add a new department to an organization
     */
    public function addDepartment(Request $request, Organization $organization)
    {
        try {
            $validated = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'unique:departments,name,NULL,id,organization_id,' . $organization->id
                ]
            ]);

            $department = $organization->departments()->create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Department added successfully',
                'department' => $department
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add department',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Delete a department from an organization
     */
    public function deleteDepartment(Organization $organization, Department $department)
    {
        try {
            if ($department->organization_id !== $organization->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Department does not belong to this organization'
                ], 403);
            }

            $department->delete();

            return response()->json([
                'success' => true,
                'message' => 'Department deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete department',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add a new location to an organization
     */
    public function addLocation(Request $request, Organization $organization)
    {
        try {
            $validated = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'unique:locations,name,NULL,id,organization_id,' . $organization->id
                ]
            ]);

            $location = $organization->locations()->create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Location added successfully',
                'location' => $location
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add location',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Delete a location from an organization
     */
    public function deleteLocation(Organization $organization, Location $location)
    {
        try {
            if ($location->organization_id !== $organization->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Location does not belong to this organization'
                ], 403);
            }

            $location->delete();

            return response()->json([
                'success' => true,
                'message' => 'Location deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete location',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
