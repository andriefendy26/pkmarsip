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
            $table->dropForeign(['lokasi_id']);
            $table->dropForeign(['rak_id']);

            $table->dropColumn('lokasi_id');
            $table->dropColumn('rak_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dokumens', function (Blueprint $table) {
            //
            // $table->foreignId('lokasi_id')->constrained('lokasis')->onDelete('cascade');
            // $table->foreignId('rak_id')->constrained('raks')->onDelete('cascade');
            
        });
    }
};
