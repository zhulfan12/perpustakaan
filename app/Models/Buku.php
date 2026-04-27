<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
