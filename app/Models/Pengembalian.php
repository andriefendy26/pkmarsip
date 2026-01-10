<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    //
    protected $table = "pengembalians";
    protected $fillable = ['peminjaman_id', 'tanggal_kembali', 'keterangan  ', 'user_id'];
    
    public function User(){
        return $this->belongsTo(User::class);
    }

    public function Peminjaman(){
        return $this->belongsTo(Peminjaman::class);
    }
}
