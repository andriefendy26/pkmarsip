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
        Schema::table('dokumens', function (Blueprint $table) {
            //
            $table->foreignId('lokasi_id')->constrained('lokasis')->onDelete('cascade');
            $table->foreignId('rak_id')->constrained('raks')->onDelete('cascade');


            //$table->string('judul');
            // $table->string('nomor_dokumen')->unique();
            // $table->string('kode_dokumen')->unique();
            // $table->text('deskripsi_dokumen')->nullable();
            // $table->text('perihal')->nullable();
            // $table->date('tanggal')->nullable();
            
            // $table->string('file_path');
            // $table->text('catatan')->nullable();
            
            // $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // $table->foreignId('jenis_dokumen_id')->constrained('jenis_dokumens')->onDelete('cascade');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dokumens', function (Blueprint $table) {
            //
        });
    }
};
