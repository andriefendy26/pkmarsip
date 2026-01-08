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
        //
        Schema::table('retensi', function (Blueprint $table) {
            $table->string('keterangan')->nullable()->after('status_retensi');
            $table->double('priode_retensi')->nullable()->after('status_retensi');
            // $table->tindakan('priode_retensi')->nullable()->after('status_retensi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('retensi');
    }
};
