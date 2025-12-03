<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = [
        'foto',
        'nama',
        'detail',
        'harga',
        'id_jenis',
        'id_satuan',
        'is_rekomendasi'
    ];

    public function satuan(){
        return $this->belongsTo(Satuan::class, 'id_satuan');
    }

    public function jenis_barang(){
        return $this->belongsTo(JenisBarang::class, 'id_jenis');
    }
}
