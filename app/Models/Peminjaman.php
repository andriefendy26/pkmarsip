<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    //
    use HasFactory;
    protected $table = "peminjamen";
    protected $fillable = ['tanggal_pinjam', 'tanggal_kembali', 'keterangan', 'user_id', 'dokumen_id'];

    
}
