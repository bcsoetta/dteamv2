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
        Schema::create('surat_keputusans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fasilitas_id')->constrained('jenis_fasilitas')->cascadeOnDelete();
            $table->string('nomor_skep')->unique();
            $table->date('tanggal_skep');
            $table->date('jatuh_tempo');
            $table->foreignId('perusahaan_id')->constrained('perusahaans')->onDelete('restrict');
            $table->string('file_skep')->unique()->nullable();
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai');
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keputusans');
    }
};
