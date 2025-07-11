<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TaskPhase;
use App\Models\Department;

class TaskPhaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phases = [
            [
                'name' => 'Planning',
                'description' => 'Initial planning and content briefing',
                'order_index' => 1,
                'department_name' => 'Production',
                'color' => '#007bff',
                'is_active' => true,
                'is_final' => false,
            ],
            [
                'name' => 'Content Creation',
                'description' => 'Recording, filming, or content creation',
                'order_index' => 2,
                'department_name' => 'Production',
                'color' => '#28a745',
                'is_active' => true,
                'is_final' => false,
            ],
            [
                'name' => 'Basic Editing',
                'description' => 'Initial video editing and assembly',
                'order_index' => 3,
                'department_name' => 'Video Editing',
                'color' => '#ffc107',
                'is_active' => true,
                'is_final' => false,
            ],
            [
                'name' => 'NLE Processing',
                'description' => 'Advanced editing and post-production',
                'order_index' => 4,
                'department_name' => 'NLE Team',
                'color' => '#fd7e14',
                'is_active' => true,
                'is_final' => false,
            ],
            [
                'name' => 'Graphics & Effects',
                'description' => 'Adding graphics, titles, and visual effects',
                'order_index' => 5,
                'department_name' => 'Graphics',
                'color' => '#e83e8c',
                'is_active' => true,
                'is_final' => false,
            ],
            [
                'name' => 'Review & Approval',
                'description' => 'Content review and quality assurance',
                'order_index' => 6,
                'department_name' => 'Content Review',
                'color' => '#6f42c1',
                'is_active' => true,
                'is_final' => false,
            ],
            [
                'name' => 'Social Media Publishing',
                'description' => 'Publishing to social media platforms',
                'order_index' => 7,
                'department_name' => 'Social Media',
                'color' => '#17a2b8',
                'is_active' => true,
                'is_final' => true,
            ],
        ];

        foreach ($phases as $phaseData) {
            $department = Department::where('name', $phaseData['department_name'])->first();
            
            if ($department) {
                TaskPhase::create([
                    'name' => $phaseData['name'],
                    'description' => $phaseData['description'],
                    'order_index' => $phaseData['order_index'],
                    'department_id' => $department->id,
                    'color' => $phaseData['color'],
                    'is_active' => $phaseData['is_active'],
                    'is_final' => $phaseData['is_final'],
                ]);
            }
        }
    }
} 