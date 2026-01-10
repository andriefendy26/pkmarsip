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
        Schema::table('retensi', function (Blueprint $table) {
            //
            $table->foreignId('jenis_dokumen_id')->constrained('jenis_dokumens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('retensi', function (Blueprint $table) {
            //
            // drop foreign and column added in up()
            $table->dropForeign(['jenis_dokumen_id']);
            $table->dropColumn('jenis_dokumen_id');
        });
    }
};
