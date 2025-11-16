<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_d_s_s_es', function (Blueprint $table) {
            $table->id();
            // FK ke DSS
            $table->foreignId('dss_id')->constrained('d_s_s_es')->onDelete('cascade');
            $table->decimal('skor_akhir', 5, 2);
            $table->text('rekomendasi_text')->nullable();
            $table->dateTime('tanggal_analisis')->useCurrent();
            // FK ke User (pekebun)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // FK ke PemetaanLahan (dari field riwayatdss di diagram)
            $table->foreignId('pemetaan_lahan_id')->nullable()->constrained('pemetaan_lahans')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_d_s_s_es');
    }
};
