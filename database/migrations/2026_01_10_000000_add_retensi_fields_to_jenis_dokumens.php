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
        Schema::table('jenis_dokumens', function (Blueprint $table) {
            $table->string('priode_retensi')->nullable()->after('deskripsi');
            $table->string('tindakan')->nullable()->after('priode_retensi');
            $table->text('keterangan')->nullable()->after('tindakan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jenis_dokumens', function (Blueprint $table) {
            $table->dropColumn(['priode_retensi', 'tindakan', 'keterangan']);
        });
    }
};
