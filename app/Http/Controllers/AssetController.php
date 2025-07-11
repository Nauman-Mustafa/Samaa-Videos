<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Organization;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AssetsImport;
use Exception;
use Illuminate\Support\Facades\Log;

use App\Models\Category;
use App\Models\Location;
use App\Models\Department;
use App\Exports\AssetsExport;


class AssetController extends Controller
{
    public function index()
    {
        return Asset::with([
            'organization',
            'location',
            'department',
            'majorCategory',
            'minorCategory'
        ])->get()->map(function ($asset) {
            return [
                'id' => $asset->id,
                'asset_tag' => $asset->asset_tag,
                'description' => $asset->description,
                'major_category' => $asset->majorCategory->name ?? 'N/A',
                'minor_category' => $asset->minorCategory->name ?? 'N/A',
                'asset_company' => $asset->asset_company,
                'organization' => $asset->organization->name ?? 'N/A',
                'location' => $asset->location->name ?? 'N/A',
                'department' => $asset->department->name ?? 'N/A',
                'model_no' => $asset->model_no,
                'serial_no' => $asset->serial_no,
                'condition' => $asset->condition,
                'status' => $asset->status,
                'matching' => $asset->matching,
                'comments' => $asset->comments,
            ];
        });
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_tag' => 'required|unique:assets',
            'major_category_id' => 'required|exists:categories,id',
            'minor_category_id' => 'required|exists:categories,id',
            'asset_category' => 'required',
            'description' => 'required',
            'organization_id' => 'required|exists:organizations,id',
            'location_id' => 'required|exists:locations,id',
            'department_id' => 'required|exists:departments,id',
            'model_no' => 'nullable',
            'serial_no' => 'nullable',
            'condition' => 'required|in:Done,Pending,In Progress',
            'status' => 'required|in:Active,Inactive,Maintenance',
            'matching' => 'nullable',
            'comments' => 'nullable'
        ]);

        try {
            $asset = Asset::create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Asset created successfully',
                'data' => $asset
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create asset',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Asset $asset)
    {
        try {
            Log::info('Fetching asset details', ['asset_id' => $asset->id]);

            $asset->load([
                'organization',
                'location',
                'department',
                'majorCategory',
                'minorCategory'
            ]);

            // Log the loaded relationships
            Log::info('Asset relationships loaded', [
                'asset_id' => $asset->id,
                'major_category' => [
                    'id' => $asset->majorCategory->id ?? null,
                    'name' => $asset->majorCategory->name ?? 'N/A'
                ],
                'minor_category' => [
                    'id' => $asset->minorCategory->id ?? null,
                    'name' => $asset->minorCategory->name ?? 'N/A'
                ],
                'organization' => $asset->organization->name ?? 'N/A',
                'location' => $asset->location->name ?? 'N/A',
                'department' => $asset->department->name ?? 'N/A'
            ]);

            $response = [
                'id' => $asset->id,
                'asset_tag' => $asset->asset_tag,
                'organization_id' => $asset->organization_id,
                'location_id' => $asset->location_id,
                'department_id' => $asset->department_id,
                'major_category_id' => $asset->major_category_id,
                'minor_category_id' => $asset->minor_category_id,
                'asset_company' => $asset->asset_company,
                'description' => $asset->description,
                'model_no' => $asset->model_no,
                'serial_no' => $asset->serial_no,
                'condition' => $asset->condition,
                'status' => $asset->status,
                'matching' => $asset->matching,
                'comments' => $asset->comments,
                // Include relationship data
                'major_category' => $asset->majorCategory ? [
                    'id' => $asset->majorCategory->id,
                    'name' => $asset->majorCategory->name
                ] : null,
                'minor_category' => $asset->minorCategory ? [
                    'id' => $asset->minorCategory->id,
                    'name' => $asset->minorCategory->name
                ] : null
            ];

            Log::info('Asset data prepared for response', [
                'asset_id' => $asset->id,
                'has_major_category' => isset($response['major_category']),
                'has_minor_category' => isset($response['minor_category'])
            ]);

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error fetching asset details', [
                'asset_id' => $asset->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Error retrieving asset details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Asset $asset)
    {
        try {
            Log::info('Updating asset', [
                'asset_id' => $asset->id,
                'request_data' => $request->all()
            ]);

            $validated = $request->validate([
                'asset_tag' => 'required|unique:assets,asset_tag,' . $asset->id,
                'major_category_id' => 'required|exists:categories,id',
                'minor_category_id' => 'required|exists:categories,id',
                'asset_company' => 'required',
                'description' => 'required',
                'organization_id' => 'required|exists:organizations,id',
                'location_id' => 'required|exists:locations,id',
                'department_id' => 'required|exists:departments,id',
                'model_no' => 'nullable',
                'serial_no' => 'nullable',
                'condition' => 'required|in:done,useable,unuseable',
                'status' => 'required|in:done,inactive,delete',
                'matching' => 'nullable',
                'comments' => 'nullable'
            ]);

            $asset->update($validated);

            // Reload the asset with relationships
            $asset->load(['organization', 'location', 'department', 'majorCategory', 'minorCategory']);

            Log::info('Asset updated successfully', [
                'asset_id' => $asset->id,
                'condition' => $asset->condition,
                'status' => $asset->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Asset updated successfully',
                'data' => [
                    'id' => $asset->id,
                    'asset_tag' => $asset->asset_tag,
                    'organization_id' => $asset->organization_id,
                    'location_id' => $asset->location_id,
                    'department_id' => $asset->department_id,
                    'major_category_id' => $asset->major_category_id,
                    'minor_category_id' => $asset->minor_category_id,
                    'asset_company' => $asset->asset_company,
                    'description' => $asset->description,
                    'model_no' => $asset->model_no,
                    'serial_no' => $asset->serial_no,
                    'condition' => $asset->condition,
                    'status' => $asset->status,
                    'matching' => $asset->matching,
                    'comments' => $asset->comments,
                    'major_category' => $asset->majorCategory ? [
                        'id' => $asset->majorCategory->id,
                        'name' => $asset->majorCategory->name
                    ] : null,
                    'minor_category' => $asset->minorCategory ? [
                        'id' => $asset->minorCategory->id,
                        'name' => $asset->minorCategory->name
                    ] : null
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update asset', [
                'asset_id' => $asset->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update asset',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();
        return response()->json(['message' => 'Asset deleted successfully']);
    }

    public function import(Request $request)
    {
        try {
            ini_set('memory_limit', '1024M');
            set_time_limit(300); // 5 minutes

            // Add detailed validation logging
            Log::info('Starting import validation', [
                'has_file' => $request->hasFile('file'),
                'content_type' => $request->file('file')->getMimeType(),
                'original_name' => $request->file('file')->getClientOriginalName(),
                'size' => $request->file('file')->getSize(),
                'organization_id' => $request->input('organization_id')
            ]);

            $validated = $request->validate([
                'file' => 'required|file|mimes:xlsx,xls,csv|max:5120', // 5MB max
                'organization_id' => 'required|exists:organizations,id'
            ]);

            DB::beginTransaction();

            $organization = Organization::findOrFail($request->organization_id);
            $import = new AssetsImport($organization);

            // Import the file
            Excel::import($import, $request->file('file'));

            $rowCount = $import->getRowCount();
            $errors = $import->getErrors();

            DB::commit();

            // If there are errors but some rows were imported
            if (count($errors) > 0) {
                Log::warning('Import completed with errors', [
                    'error_count' => count($errors),
                    'errors' => $errors,
                    'imported_count' => $rowCount
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Import completed with errors',
                    'errors' => $errors,
                    'imported_count' => $rowCount
                ], 422);
            }

            // Successful import
            return response()->json([
                'success' => true,
                'message' => 'Assets imported successfully',
                'imported_count' => $rowCount
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Import failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Import failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getAssetStatistics()
    {
        $statistics = [
            'total_assets' => Asset::count(),
            'active_assets' => Asset::where('status', 'done')->count(),
            'unuseable_assets' => Asset::where('condition', 'unuseable')->count(),
            'deleted_assets' => Asset::where('status', 'delete')->count(),
            'total_organizations' => Organization::count(),
            'total_locations' => Location::count(),
            'assets_by_category' => $this->getAssetsByCategory()
        ];

        return response()->json($statistics);
    }
    protected function getAssetsByCategory()
    {
        return DB::table('assets')
            ->join('categories', 'assets.major_category_id', '=', 'categories.id')
            ->select('categories.name as category_name', DB::raw('count(*) as total'))
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total', 'desc')
            ->get();
    }

    public function export()
    {
        try {
            Log::info('Starting assets export');

            return Excel::download(new AssetsExport, 'assets.xlsx');

        } catch (\Exception $e) {
            Log::error('Export failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Export failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getDashboardStats()
    {
        try {
            // Basic Statistics
            $totalAssets = Asset::count();
            $activeAssets = Asset::where('status', 'done')->count();
            $maintenanceAssets = Asset::where('status', 'maintenance')->count();
            $unuseableAssets = Asset::where('condition', 'unuseable')->count();

            // Assets by Category with Percentage
            $assetsByCategory = DB::table('assets')
                ->join('categories', 'assets.major_category_id', '=', 'categories.id')
                ->select(
                    'categories.name',
                    DB::raw('count(*) as total')
                )
                ->groupBy('categories.id', 'categories.name')
                ->get()
                ->map(function ($item) use ($totalAssets) {
                    return [
                        'name' => $item->name,
                        'total' => $item->total,
                        'percentage' => $totalAssets > 0
                            ? round(($item->total / $totalAssets) * 100, 1)
                            : 0
                    ];
                });

            // Assets by Location
            $assetsByLocation = DB::table('assets')
                ->join('locations', 'assets.location_id', '=', 'locations.id')
                ->select(
                    'locations.name',
                    DB::raw('count(*) as total')
                )
                ->groupBy('locations.id', 'locations.name')
                ->get();

            // Assets by Department
            $assetsByDepartment = DB::table('assets')
                ->join('departments', 'assets.department_id', '=', 'departments.id')
                ->select(
                    'departments.name',
                    DB::raw('count(*) as total')
                )
                ->groupBy('departments.id', 'departments.name')
                ->get();

            // Recent Assets
            $recentAssets = Asset::with(['majorCategory', 'location', 'department'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
                ->map(function ($asset) {
                    return [
                        'asset_tag' => $asset->asset_tag,
                        'description' => $asset->description,
                        'category' => $asset->majorCategory ? $asset->majorCategory->name : 'N/A',
                        'location' => $asset->location ? $asset->location->name : 'N/A',
                        'department' => $asset->department ? $asset->department->name : 'N/A',
                        'status' => $asset->status,
                        'condition' => $asset->condition,
                        'created_at' => $asset->created_at
                    ];
                });

            // Assets by Status
            $assetsByStatus = Asset::select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get()
                ->map(function ($item) use ($totalAssets) {
                    return [
                        'name' => $item->status,
                        'total' => $item->total,
                        'percentage' => $totalAssets > 0
                            ? round(($item->total / $totalAssets) * 100, 1)
                            : 0
                    ];
                });

            return response()->json([
                'summary' => [
                    'total_assets' => $totalAssets,
                    'active_assets' => $activeAssets,
                    'maintenance_assets' => $maintenanceAssets,
                    'unuseable_assets' => $unuseableAssets
                ],
                'assetsByCategory' => $assetsByCategory,
                'assetsByLocation' => $assetsByLocation,
                'assetsByDepartment' => $assetsByDepartment,
                'assetsByStatus' => $assetsByStatus,
                'recentAssets' => $recentAssets
            ]);

        } catch (\Exception $e) {
            \Log::error('Dashboard stats error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            return response()->json([
                'error' => 'Failed to fetch dashboard statistics',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
}
