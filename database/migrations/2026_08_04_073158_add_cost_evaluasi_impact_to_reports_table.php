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
        Schema::table('reports', function (Blueprint $table) {
            $table->decimal('cost_proyek', 15, 2)->default(0)->after('nilai_proyek');
            $table->text('evaluasi')->nullable()->after('masalah_yang_diselesaikan');
            $table->text('impact')->nullable()->after('evaluasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn(['cost_proyek', 'evaluasi', 'impact']);
        });
    }
};
