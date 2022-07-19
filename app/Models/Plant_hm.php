<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant_hm extends Model
{
    use HasFactory;

    protected $table = 'plant_hm';
    protected $fillable = ['nom_unit', 'hm', 'km', 'tgl', 'kodesite', 'del'];
    public $timestamps = false;
}
