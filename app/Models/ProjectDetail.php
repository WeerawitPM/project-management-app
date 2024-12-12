<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectDetail extends Model
{
    protected $fillable = [
        'project_head_id',
        'project_phase_id',
        'start_date',
        'end_date',
        'status_id'
    ];

    public function project_head()
    {
        return $this->belongsTo(ProjectHead::class);
    }

    public function project_phase()
    {
        return $this->belongsTo(ProjectPhase::class);
    }

    public function status()
    {
        return $this->belongsTo(ProjectDetailStatus::class);
    }
}
