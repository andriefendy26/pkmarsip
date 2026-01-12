<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    //
    protected $table = "raks";
    protected $fillable = ['kode_rak', 'nama_rak', 'deskripsi', 'lokasi_id'];

    public function Lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function Box()
    {
        return $this->hasMany(Box::class, 'rak_id', 'id');
    }
    
}
