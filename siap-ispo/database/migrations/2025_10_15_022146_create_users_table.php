<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable(); // TAMBAHKAN INI
            $table->string('password', 255);
            $table->string('remember_token', 100)->nullable(); // PERBAIKI LENGTH
            $table->enum('role', ['admin', 'pekebun']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
