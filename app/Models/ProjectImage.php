<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectImage extends Model
{
    protected $fillable = [
        'image',
        'project_head_id',
    ];

    protected $casts = [
        'image' => 'array',
    ];

    public function project_head()
    {
        return $this->belongsTo(ProjectHead::class);
    }
}
