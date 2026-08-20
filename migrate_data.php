<?php
use App\Models\Project;
use App\Models\ProjectTask;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$projects = Project::all();
foreach ($projects as $project) {
    if ($project->tasks()->count() == 0) {
        ProjectTask::create([
            'project_id' => $project->id,
            'nama_task' => 'Tugas Utama',
            'pic' => $project->pic,
            'status_task' => $project->status_project ?? 'Not yet',
            'priority' => $project->priority ?? 'Medium',
            'target_selesai' => $project->target_selesai,
            'kendala_issue' => $project->kendala_issue,
        ]);
        echo "Migrated project: " . $project->nama_project . "\n";
    }
}
echo "Data migration complete.\n";
