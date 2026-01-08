<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Dokumen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Application;

// Bootstrap Laravel
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing auto user_id assignment...\n";

// Cek apakah ada user yang login
if (Auth::check()) {
    echo 'User login: ' . Auth::id() . "\n";

    // Coba buat dokumen dengan data minimal
    try {
        $dokumen = new Dokumen([
            'judul' => 'Test Auto User ID',
            'nomor_dokumen' => 'AUTO-001',
            'kode_dokumen' => 'AUTO001',
            'tanggal' => now()->format('Y-m-d'),
            'jenis_dokumen_id' => 1,
            'lokasi_id' => 1,
            'rak_id' => 1,
        ]);

        // Simpan untuk trigger event creating
        $dokumen->save();

        echo 'Dokumen berhasil dibuat dengan user_id: ' . $dokumen->user_id . "\n";
        echo 'User yang login: ' . Auth::id() . "\n";
        echo 'Status: ' . ($dokumen->user_id == Auth::id() ? 'BERHASIL' : 'GAGAL') . "\n";

        // Hapus dokumen test
        $dokumen->delete();
        echo "Test dokumen dihapus.\n";

    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage() . "\n";
    }
} else {
    echo 'Tidak ada user yang login' . "\n";
}