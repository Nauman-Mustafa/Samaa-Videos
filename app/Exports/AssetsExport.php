<?php

namespace App\Exports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AssetsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return Asset::with([
            'location',
            'department',
            'majorCategory',
            'minorCategory'
        ])->get();
    }

    public function headings(): array
    {
        return [
            'Asset Tag',
            'Description',
            'Major Category',
            'Minor Category',
            'Asset Company',
            'Location',
            'Department',
            'Model No',
            'Serial No',
            'Condition',
            'Status',
            'Comments'
        ];
    }

    public function map($asset): array
    {
        return [
            $asset->asset_tag,
            $asset->description,
            $asset->majorCategory->name ?? 'N/A',
            $asset->minorCategory->name ?? 'N/A',
            $asset->asset_company,
            $asset->location->name ?? 'N/A',
            $asset->department->name ?? 'N/A',
            $asset->model_no,
            $asset->serial_no,
            $asset->condition,
            $asset->status,
            $asset->comments
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
