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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->year('tahun')->nullable();
            $table->string('klien')->nullable();
            $table->string('industri')->nullable();
            $table->string('jenis_perusahaan')->nullable();
            $table->decimal('nilai_proyek', 15, 2)->default(0);
            $table->decimal('real_income', 15, 2)->default(0);
            $table->string('layanan')->nullable();
            $table->float('margin_persen')->default(0);
            $table->decimal('real_margin', 15, 2)->default(0);
            $table->string('datang_dari_siapa')->nullable();
            $table->boolean('repeat')->default(false);
            $table->float('keterlibatan_puti_persen')->default(0);
            $table->text('masalah_yang_diselesaikan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
