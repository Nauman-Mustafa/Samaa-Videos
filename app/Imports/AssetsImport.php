<?php

namespace App\Imports;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Location;
use App\Models\Department;
use App\Models\Organization;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Throwable;
use Maatwebsite\Excel\Validators\Failure;

class AssetsImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts
{
    private $rows = 0;
    private $errors = [];
    protected $organization;
    protected $locationCache = [];
    protected $categoryCache = [];
    protected $departmentCache = [];
    protected $rowCount = 0;

    public function __construct(Organization $organization)
    {
        $this->organization = $organization;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $rowNum => $row) {
            try {
                // Debug log for row data
                Log::info('Processing row', [
                    'row_number' => $rowNum + 2,
                    'department' => $row['department'] ?? 'not set',
                    'asset_tag' => $row['asset_tag_no'] ?? 'not set',
                    'asset_company' => $row['asset_company'] ?? 'not set'
                ]);

                // Skip empty rows
                if (empty($row) || empty($row['asset_tag_no'])) {
                    continue;
                }

                // Validate required fields
                $requiredFields = ['asset_tag_no', 'city', 'major_category', 'minor_category', 'asset_description'];
                foreach ($requiredFields as $field) {
                    if (empty($row[$field])) {
                        throw new \Exception("Missing required field: {$field}");
                    }
                }

                // Get or create location from city
                $location = $this->getOrCreateLocation($row['city']);

                // Get or create major category (parent)
                $majorCategory = $this->getOrCreateCategory($row['major_category']);

                // Get or create minor category (child of major category)
                $minorCategory = $this->getOrCreateCategory($row['minor_category'], $majorCategory->id);

                // Get or create department - using the 'department' column
                $department = null;
                if (isset($row['department']) && !empty($row['department'])) {
                    $department = $this->getOrCreateDepartment($row['department']);

                    // Debug log for department assignment
                    Log::info('Department assigned', [
                        'department_id' => $department ? $department->id : null,
                        'department_name' => $department ? $department->name : null,
                        'asset_tag' => $row['asset_tag_no']
                    ]);
                }

                // Create the asset with proper relationships
                $asset = Asset::create([
                    'asset_tag' => $row['asset_tag_no'],
                    'organization_id' => $this->organization->id,
                    'location_id' => $location->id,
                    'department_id' => $department ? $department->id : null,
                    'major_category_id' => $majorCategory->id,
                    'minor_category_id' => $minorCategory->id,
                    'asset_company' => $row['asset_company'] ?? null,
                    'description' => $row['asset_description'],
                    'model_no' => $row['model_no'] ?? null,
                    'serial_no' => $row['serial_no'] ?? null,
                    'condition' => $row['condition'] ?? null,
                    'status' => $row['status'] ?? $this->determineStatus($row['condition'] ?? 'Done'),
                    'matching' => $row['matching'] ?? null,
                    'comments' => $this->buildComments($row)
                ]);

                // Verify asset creation with company
                Log::info('Asset created', [
                    'asset_id' => $asset->id,
                    'department_id' => $asset->department_id,
                    'asset_tag' => $asset->asset_tag,
                    'asset_company' => $asset->asset_company
                ]);

                $this->rowCount++;

            } catch (\Exception $e) {
                Log::error('Row import failed', [
                    'row_number' => $rowNum + 2,
                    'error' => $e->getMessage(),
                    'row_data' => $row
                ]);
                $this->errors[] = "Row " . ($rowNum + 2) . ": " . $e->getMessage();
            }
        }
    }

    /**
     * Map Excel condition to standard condition values
     */
    private function mapCondition($condition)
    {
        if (empty($condition)) {
            return 'Done';
        }

        $condition = strtolower(trim($condition));

        if (strpos($condition, 'useable') !== false || strpos($condition, 'good') !== false) {
            return 'Done';
        } else if (strpos($condition, 'repair') !== false || strpos($condition, 'progress') !== false) {
            return 'In Progress';
        } else if (strpos($condition, 'pending') !== false || strpos($condition, 'wait') !== false) {
            return 'Pending';
        }

        return 'Done'; // Default
    }

    /**
     * Determine status based on condition
     */
    private function determineStatus($condition)
    {
        switch ($condition) {
            case 'Done':
                return 'Active';
            case 'Pending':
                return 'Inactive';
            case 'In Progress':
                return 'Maintenance';
            default:
                return 'Active';
        }
    }

    /**
     * Build comments from additional information in the row
     */
    private function buildComments($row)
    {
        $comments = [];

        if (!empty($row['comments'])) {
            $comments[] = $row['comments'];
        }

        if (!empty($row['new_location'])) {
            $comments[] = "New Location: " . $row['new_location'];
        }

        return implode("; ", $comments);
    }

    public function rules(): array
    {
        return [
            'asset_tag_no' => 'required',
            'city' => 'required',
            'major_category' => 'required',
            'minor_category' => 'required',
        ];
    }

    public function onError(Throwable $e)
    {
        $this->errors[] = $e->getMessage();
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->errors[] = "Row {$failure->row()}: {$failure->errors()[0]}";
        }
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function batchSize(): int
    {
        return 100;
    }

    protected function getOrCreateLocation($cityName)
    {
        if (empty($cityName)) {
            throw new \Exception('City name cannot be empty');
        }

        $key = Str::slug($cityName);
        if (isset($this->locationCache[$key])) {
            return $this->locationCache[$key];
        }

        $location = Location::firstOrCreate([
            'name' => $cityName,
            'organization_id' => $this->organization->id
        ]);

        $this->locationCache[$key] = $location;
        return $location;
    }

    protected function getOrCreateCategory($name, $parentId = null)
    {
        if (empty($name)) {
            throw new \Exception('Category name cannot be empty');
        }

        // Create a composite key for caching
        $key = $parentId ? "{$name}-{$parentId}" : $name;
        if (isset($this->categoryCache[$key])) {
            return $this->categoryCache[$key];
        }

        // Find existing category with same name and parent
        $category = Category::where('name', $name)
            ->where('parent_id', $parentId)
            ->first();

        if (!$category) {
            // Create new category if not found
            $category = Category::create([
                'name' => $name,
                'parent_id' => $parentId
            ]);
        }

        $this->categoryCache[$key] = $category;
        return $category;
    }

    protected function getOrCreateDepartment($departmentName)
    {
        if (empty($departmentName)) {
            Log::warning('Empty department name provided');
            return null;
        }

        $departmentName = trim($departmentName);
        $key = Str::slug($departmentName);

        // Debug log
        Log::info('Processing department', [
            'name' => $departmentName,
            'organization_id' => $this->organization->id
        ]);

        // Check cache first
        if (isset($this->departmentCache[$key])) {
            return $this->departmentCache[$key];
        }

        try {
            // Find existing department
            $department = Department::where('name', $departmentName)
                ->where('organization_id', $this->organization->id)
                ->first();

            // If not found, create new
            if (!$department) {
                $department = Department::create([
                    'name' => $departmentName,
                    'organization_id' => $this->organization->id
                ]);

                Log::info('Created new department', [
                    'id' => $department->id,
                    'name' => $department->name,
                    'organization_id' => $department->organization_id
                ]);
            }

            // Store in cache
            $this->departmentCache[$key] = $department;

            return $department;

        } catch (\Exception $e) {
            Log::error('Failed to create/find department', [
                'name' => $departmentName,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}
