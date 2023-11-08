<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimnasIndonesia extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $table = 'timnas_indonesia';
    protected $fillable = [
        'nama_pemain',
        'daerah_asal_pemain',
        'posisi_pemain'
    ];

    // protected $hidden = [];

}
