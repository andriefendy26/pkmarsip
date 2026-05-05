<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lokasi extends Model
{
    use HasFactory;

    protected $table = "lokasis";

    protected $fillable = ['kode_lokasi', 'nama_lokasi', 'deskripsi','ruangan_id'];

    public function Rak(): HasMany
    {
        return $this->hasMany(Rak::class, 'lokasi_id', 'id');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }
    
    // public function rak(): HasMany
    // {
    //     return $this->hasMany(Rak::class, 'lokasi_id', 'id');
    // }

    public function raks(): HasMany
    {
        return $this->hasMany(Rak::class, 'lokasi_id', 'id');
    }
}

