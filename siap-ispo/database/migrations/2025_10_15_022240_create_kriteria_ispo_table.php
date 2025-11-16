<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kriteria_ispo', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kriteria', 10)->unique();
            $table->string('nama_kriteria', 100);
            $table->text('indikator');
            $table->string('prinsip', 100);
            $table->text('verifier')->nullable();
            $table->enum('jenis', ['benefit', 'cost']);
            $table->decimal('bobot', 5, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kriteria_ispo');
    }
};
