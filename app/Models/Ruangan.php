<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Lokasi;

class Ruangan extends Model
{
    //
    use Hasfactory;
    protected $table = "ruangans";
    protected $fillable = ['kode_ruangan', 'nama_ruangan', 'deskripsi'];

    public function lokasis()
    {
        return $this->hasMany(Lokasi::class, 'ruangan_id');
    }

}
