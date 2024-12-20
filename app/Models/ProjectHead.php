<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectHead extends Model
{
    protected $fillable = [
        'name',
        'company_id',
        'assign_id',
        'status_id',
        'start_date',
        'end_date',
        'images',
        'request_by',
        'logo',
        'status_new_old_id',
        'actual_start_date',
        'actual_end_date',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function assign()
    {
        return $this->belongsTo(Assign::class);
    }

    public function status()
    {
        return $this->belongsTo(ProjectStatus::class);
    }

    public function status_new_old()
    {
        return $this->belongsTo(ProjectStatusNewOld::class);
    }
}
