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
        Schema::create('rekam_lhps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skep_id')->constrained('surat_keputusans')->cascadeOnDelete();
            $table->dateTime('mulai_periksa');
            $table->dateTime('selesai_periksa');
            $table->string('lokasi');
            $table->string('tujuan');
            $table->string('hasil');
            $table->string('kesimpulan');
            $table->string('kesesuaian');
            $table->string('saksi');
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('pemeriksa_pertama')->constrained('users')->onDelete('restrict');
            $table->foreignId('pemeriksa_kedua')->constrained('users')->onDelete('restrict')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_lhps');
    }
};
