<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian_d_s_s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pemetaan_lahan_id')->constrained('pemetaan_lahans')->onDelete('cascade');
            $table->foreignId('kriteria_id')->constrained('kriteria_ispo')->onDelete('cascade');
            $table->decimal('nilai', 8, 2);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian_d_s_s');
    }
};
