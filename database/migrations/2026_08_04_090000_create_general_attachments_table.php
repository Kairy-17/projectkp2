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
        Schema::create('general_attachments', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe', ['file', 'link']);
            $table->string('judul_dokumen');
            $table->string('path_atau_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_attachments');
    }
};
