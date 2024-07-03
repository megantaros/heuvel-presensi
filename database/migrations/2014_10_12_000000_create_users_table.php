<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nip', 10)->nullable();
            $table->string('email')->unique();
            // $table->string('divisi')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->char('password', 60);
            $table->rememberToken();
            $table->unsignedBigInteger('id_jabatan');
            $table->timestamps();

            $table->foreign('id_jabatan')->references('id')->on('jabatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};