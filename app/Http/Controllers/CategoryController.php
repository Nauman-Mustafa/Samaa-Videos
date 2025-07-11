<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::where('status', '!=', 'Deleted')->with('parent')->get();
            return response()->json($categories);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving categories', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:categories',
                'status' => 'required|string',
                'parent_id' => 'nullable|exists:categories,id'
            ]);

            $category = Category::create($validatedData);
            return response()->json($category, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating category', 'error' => $e->getMessage()], 500);
        }
    }

    public function show(Category $category)
    {
        try {
            return response()->json($category);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving category', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Category $category)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
                'status' => 'required|string',
                'parent_id' => 'nullable|exists:categories,id'
            ]);

            $category->update($validatedData);
            return response()->json($category);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating category', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Category $category)
    {
        try {
            $category->update(['status' => 'Deleted']);
            return response()->json(['message' => 'Category deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting category', 'error' => $e->getMessage()], 500);
        }
    }
    public function getCategoryStatistics()
    {
        try {
            $totalCategories = Category::count();
            $activeCategories = Category::where('status', 'Active')->count();
            $deletedCategories = Category::where('status', 'Deleted')->count();
            $parentCategories = Category::whereNull('parent_id')->count();

            return response()->json([
                'total_categories' => $totalCategories,
                'active_categories' => $activeCategories,
                'deleted_categories' => $deletedCategories,
                'parent_categories' => $parentCategories,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving category statistics', 'error' => $e->getMessage()], 500);
        }
    }

    public function getMajorCategories()
    {
        try {
            Log::info('Fetching major categories');

            $categories = Category::whereNull('parent_id')
                ->where('status', '1')
                ->select('id', 'name')
                ->get()
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name
                    ];
                });

            Log::info('Major categories fetched', [
                'count' => $categories->count(),
                'categories' => $categories->toArray()
            ]);

            return response()->json($categories);
        } catch (\Exception $e) {
            Log::error('Error fetching major categories', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Error retrieving major categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getMinorCategories($parentId)
    {
        try {
            Log::info('Fetching minor categories', ['parent_id' => $parentId]);

            $categories = Category::where('parent_id', $parentId)
                ->where('status', '1')
                ->select('id', 'name')
                ->get()
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name
                    ];
                });

            Log::info('Minor categories fetched', [
                'parent_id' => $parentId,
                'count' => $categories->count(),
                'categories' => $categories->toArray()
            ]);

            return response()->json($categories);
        } catch (\Exception $e) {
            Log::error('Error fetching minor categories', [
                'parent_id' => $parentId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Error retrieving minor categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

