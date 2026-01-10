<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    //
    use HasFactory;
    protected $table = "peminjaman";
    protected $fillable = ['kode_peminjaman', 'tanggal_pinjam', 'tanggal_kembali', 'keterangan', 'user_id', 'dokumen_id'];

    public function User(){
        return $this->belongsTo(User::class);
    }
    public function Dokumen(){
        return $this->belongsTo(Dokumen::class);
    }
}
