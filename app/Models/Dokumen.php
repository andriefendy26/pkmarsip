<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Dokumen extends Model
{
    protected $table = "dokumens";

    protected $fillable = [
        'judul',
        'nomor_dokumen',
        'kode_dokumen',
        'deskripsi_dokumen',
        'perihal',
        'tanggal',
        'file_path',
        'catatan',
        'user_id',
        'jenis_dokumen_id',
        'created_at',
        'updated_at',

        // 'lokasi_id',
        // 'rak_id',
        'box_id',   
        // 'status'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check() && !$model->user_id) {
                $model->user_id = Auth::id();
            }
        });
    }

    public function jenisDokumen(): BelongsTo
    {
        return $this->belongsTo(JenisDokumen::class);
    }

    // public function lokasi(): BelongsTo
    // {
    //     return $this->belongsTo(Lokasi::class);
    // }

    // public function rak(): BelongsTo
    // {
    //     return $this->belongsTo(Rak::class);
    // }

    public function box(): BelongsTo
    {
        return $this->belongsTo(Box::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
