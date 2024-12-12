<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectImage extends Model
{
    protected $fillable = [
        'name',
        'project_head_id',
    ];

    public function project_head()
    {
        return $this->belongsTo(ProjectHead::class);
    }
}
