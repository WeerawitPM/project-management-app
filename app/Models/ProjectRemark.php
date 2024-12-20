<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectRemark extends Model
{
    protected $fillable = [
        'project_detail_id',
        'remark',
        'start_date',
        'end_date',
    ];

    public function project_detail()
    {
        return $this->belongsTo(ProjectDetail::class);
    }
}
