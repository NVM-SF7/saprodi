<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings'; // opsional kalau nama sudah sama

    // Izinkan mass assignment untuk field ini
    protected $fillable = ['key', 'value'];
}
