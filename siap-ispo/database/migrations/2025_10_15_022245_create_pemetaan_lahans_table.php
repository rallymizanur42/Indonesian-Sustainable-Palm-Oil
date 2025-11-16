<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemetaan_lahans', function (Blueprint $table) {
            $table->id();
            $table->string('id_lahan', 50)->unique(); // TAMBAHKAN KOLOM INI
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); // TAMBAHKAN nullable()
            $table->string('deskripsi', 100)->nullable();
            $table->string('desa', 100)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('status_ispo', 100)->nullable();
            $table->string('tingkat_kesiapan', 100)->nullable();
            $table->decimal('luas_lahan', 10, 2)->nullable();
            $table->string('geometry_type', 100)->nullable();
            $table->json('geometry')->nullable(); // Ubah dari string ke json
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemetaan_lahans');
    }
};
