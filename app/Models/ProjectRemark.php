<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectRemark extends Model
{
    protected $fillable = [
        'project_head_id',
        'remark',
        'start_date',
        'end_date',
    ];

    public function project_head()
    {
        return $this->belongsTo(ProjectHead::class);
    }
}
