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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('nip')->unique();
            $table->string('nama');
            $table->string('email')->nullable();
            $table->string('departemen');
            $table->string('jabatan');
            $table->date('tanggal_masuk');
            $table->decimal('gaji_dasar', 15, 2)->default(0);
            $table->string('no_rekening')->nullable();
            $table->string('nama_bank')->nullable();
            $table->string('npwp')->nullable();
            $table->string('status')->default('aktif');
            $table->text('alamat')->nullable();
            $table->string('no_hp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
