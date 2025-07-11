<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_tag',
        'organization_id',
        'location_id',
        'department_id',
        'major_category_id',
        'minor_category_id',
        'asset_company',
        'description',
        'model_no',
        'serial_no',
        'condition',
        'status',
        'matching',
        'comments'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function majorCategory()
    {
        return $this->belongsTo(Category::class, 'major_category_id');
    }

    public function minorCategory()
    {
        return $this->belongsTo(Category::class, 'minor_category_id');
    }
}
