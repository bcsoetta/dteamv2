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
        Schema::create('tindak_lanjut_skeps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skep_id')->constrained('surat_keputusans')->cascadeOnDelete();
            $table->foreignId('tindak_lanjut_id')->constrained('jenis_tindak_lanjuts')->cascadeOnDelete();
            $table->string('nomor_surat_tindak_lanjut')->unique();
            $table->date('tanggal_surat_tindak_lanjut');
            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->unsignedBigInteger('nilai_tindak_lanjut_rupiah')->nullable();
            $table->string('file_tindak_lanjut')->unique();
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
        Schema::dropIfExists('tindak_lanjut_skeps');
    }
};
