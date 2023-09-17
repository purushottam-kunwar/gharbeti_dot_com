<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FiscalYear extends Model
{
    protected $table = 'fiscal_year';

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'bs_start_date',
        'bs_end_date',
        'ad_start_date',
        'ad_end_date',
        'status',
    ];
}
