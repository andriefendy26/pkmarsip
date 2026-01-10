<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\JenisDokumen;

class Retensi extends Model
{
    use HasFactory;

    protected $table = "retensi";

    protected $fillable = [
        'keterangan', 
        'priode_retensi', 
        'tindakan',
        'jenis_dokumen_id'
    ];

    // protected $fillable = ['kode_lokasi', 'nama_lokasi', 'deskripsi'];

    public function jenisDokumen(): BelongsTo
    {
        return $this->belongsTo(JenisDokumen::class);
    }

    protected static function booted()
    {
        parent::boot();

        static::saved(function ($retensi) {
            if ($retensi->jenis_dokumen_id) {
                $jenis = JenisDokumen::find($retensi->jenis_dokumen_id);
                if ($jenis) {
                    $jenis->priode_retensi = $retensi->priode_retensi;
                    $jenis->tindakan = $retensi->tindakan;
                    // optionally copy keterangan if you want it on jenis
                    if (isset($retensi->keterangan)) {
                        $jenis->keterangan = $retensi->keterangan;
                    }
                    $jenis->save();
                }
            }
        });

        static::deleted(function ($retensi) {
            if ($retensi->jenis_dokumen_id) {
                $jenis = JenisDokumen::find($retensi->jenis_dokumen_id);
                if ($jenis) {
                    $jenis->priode_retensi = null;
                    $jenis->tindakan = null;
                    $jenis->save();
                }
            }
        });
    }
}
