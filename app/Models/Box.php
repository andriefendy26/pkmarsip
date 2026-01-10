<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    //
    protected $table = "box";
    protected $fillable = ['kode_box', 'nama_box', 'deskripsi', 'rak_id'];
    
}
