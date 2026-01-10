<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Box extends Model
{
    //
    protected $table = "box";
    protected $fillable = ['kode_box', 'nama_box', 'deskripsi', 'qr_code_path', 'rak_id'];
    
    protected static function booted()
    {
        parent::boot();

        static::created(function ($box) {
            $box->generateQrCode();
        });
    }

    public function rak()
    {
        return $this->belongsTo(Rak::class);
    }

    public function dokumens()
    {
        return $this->hasMany(Dokumen::class);
    }

    public function generateQrCode()
    {
        //cek jika sudah ada qr code tidak usah generate ulang
        if ($this->qr_code_path) {
            return;
        }
        //membuat url untuk qr code
        $url = url('/admin/boxes/' . $this->id);

        //membuat qr code
        $qrCode = QrCode::format('svg')->size(200)->generate($url);

        // Save to storage
        $path = 'qr-codes/box' . $this->id . '.svg';
        Storage::disk('public')->put($path, $qrCode);

        // Update the model
        $this->update(['qr_code_path' => $path]);
    }

        public function getQrCodeUrlAttribute()
        {
            return $this->qr_code_path ? asset('storage/' . $this->qr_code_path) : null;
        }

}
