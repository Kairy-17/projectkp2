<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_id')->unique();
            $table->string('nama_project');
            $table->text('deskripsi_singkat')->nullable();
            $table->integer('tahun')->nullable();
            $table->integer('bulan')->nullable();
            $table->integer('minggu')->nullable();
            $table->text('pic')->nullable(); // Store JSON array of PICs
            $table->enum('status_project', ['Not yet', 'On going', 'Hold', 'Done'])->default('Not yet');
            $table->enum('priority', ['High', 'Medium', 'Low'])->default('Medium');
            $table->string('durasi_project')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('target_selesai')->nullable();
            $table->date('tanggal_selesai_aktual')->nullable();
            $table->integer('progress')->default(0);
            $table->string('milestone_saat_ini')->nullable();
            $table->string('next_action')->nullable();
            $table->text('kendala_issue')->nullable();
            $table->string('contact_client')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
