<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LocalAreaFacilities extends Model
{
    protected $table = 'local_area_facilities';

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];
}
