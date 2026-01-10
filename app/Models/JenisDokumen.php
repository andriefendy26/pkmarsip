<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Retensi;
use Illuminate\Database\Eloquent\SoftDeletes;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class JenisDokumen extends Model
{
    //
    use HasFactory;
    // use SoftDeletes;
    protected $table = "jenis_dokumens";

    protected $fillable = ['nama_jenis_dokumen', 'deskripsi', 'qr_code_path', 'priode_retensi', 'tindakan', 'keterangan'];

    public function Dokumens(): HasMany
    {
        return $this->hasMany(Dokumen::class);
    }
    // public function retensis(): HasMany
    // {
    //     return $this->hasMany(Retensi::class);
    // }

    // Allow mass assignment for retensi-related fields
    protected $guarded = [];

    protected static function booted()
    {
        parent::boot();

        static::created(function ($jenisDokumen) {
            $jenisDokumen->generateQrCode();
        });
    }

    public function generateQrCode()
    {
        //cek jika sudah ada qr code tidak usah generate ulang
        if ($this->qr_code_path) {
            return;
        }
        //membuat url untuk qr code
        $url = url('/admin/jenis-dokumens/' . $this->id);

        //membuat qr code
        $qrCode = QrCode::format('svg')->size(200)->generate($url);

        // Save to storage
        $path = 'qr-codes/' . $this->id . '.svg';
        Storage::disk('public')->put($path, $qrCode);

        // Update the model
        $this->update(['qr_code_path' => $path]);
    }

    public function getQrCodeUrlAttribute()
    {
        return $this->qr_code_path ? asset('storage/' . $this->qr_code_path) : null;
    }
}
