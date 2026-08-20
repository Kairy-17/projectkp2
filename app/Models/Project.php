<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    protected $casts = [
        'pic' => 'array',
    ];

    public function tasks()
    {
        return $this->hasMany(ProjectTask::class);
    }
}
