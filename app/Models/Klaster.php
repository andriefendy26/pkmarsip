<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Klaster extends Model
{
    //
    use HasFactory;

    protected $table = "klaster";

    protected $fillable = ['nama_klaster'];

    public function users()
    {
        return $this->hasMany(User::class, 'klaster_id', 'id');
    }
}
