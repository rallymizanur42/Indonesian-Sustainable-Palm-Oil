<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('informasi_ispo', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 100);
            $table->string('syarat_ispo', 100)->nullable();
            $table->string('deskripsi', 100)->nullable();
            $table->string('manfaat', 100)->nullable();
            $table->string('fitur', 100)->nullable();
            $table->string('gambar', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('informasi_ispo');
    }
};
