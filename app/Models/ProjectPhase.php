<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectPhase extends Model
{
    protected $fillable = [
        'name',
    ];

    public function projectDetails()
    {
        return $this->hasMany(ProjectDetail::class, 'project_phase_id');
    }
}
