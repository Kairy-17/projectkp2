<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTask extends Model
{
    protected $guarded = [];

    protected $casts = [
        'pic' => 'array',
        'target_selesai' => 'date',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function details()
    {
        return $this->hasMany(ProjectTaskDetail::class, 'project_task_id');
    }
}
