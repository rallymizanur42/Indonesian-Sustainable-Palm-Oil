<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('d_s_s_es', function (Blueprint $table) {
            $table->id();
            // FK ke User (pekebun)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // FK ke KriteriaISPO
            $table->foreignId('kriteria_ispo_id')->constrained('kriteria_ispo')->onDelete('cascade');
            $table->string('parameter_kriteria_ispo', 255)->nullable();
            $table->decimal('skor_kesiapan', 5, 2);
            $table->enum('level_kesiapan', ['rendah', 'sedang', 'tinggi']);
            $table->text('rekomendasi_text')->nullable();
            $table->dateTime('tanggal_dibuat')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('d_s_s_es');
    }
};
