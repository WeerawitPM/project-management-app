<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectStatusNewOld extends Model
{
    protected $fillable = [
        'name',
        'status',
    ];
}
