<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTaskDetail extends Model
{
    protected $guarded = [];

    public function task()
    {
        return $this->belongsTo(ProjectTask::class, 'project_task_id');
    }
}
