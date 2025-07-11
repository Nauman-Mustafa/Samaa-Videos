<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Production',
                'description' => 'Content creation, planning, and show production',
                'color' => '#007bff',
                'is_active' => true,
            ],
            [
                'name' => 'Video Editing',
                'description' => 'Post-production and video editing team',
                'color' => '#28a745',
                'is_active' => true,
            ],
            [
                'name' => 'NLE Team',
                'description' => 'Non-linear editing specialists',
                'color' => '#ffc107',
                'is_active' => true,
            ],
            [
                'name' => 'Graphics',
                'description' => 'Graphics design and visual effects',
                'color' => '#e83e8c',
                'is_active' => true,
            ],
            [
                'name' => 'Content Review',
                'description' => 'Content quality assurance and approval',
                'color' => '#6f42c1',
                'is_active' => true,
            ],
            [
                'name' => 'Social Media',
                'description' => 'Social media management and publishing',
                'color' => '#17a2b8',
                'is_active' => true,
            ],
            [
                'name' => 'Administration',
                'description' => 'Administrative and management tasks',
                'color' => '#6c757d',
                'is_active' => true,
            ],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
} 