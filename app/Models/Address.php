<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    protected $table = 'address';

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'province',
        'district',
        'local_body',
        'tole_or_village',
        'ward_no',
        'house_no',
        'remarks',
        'user_id'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'user');
    }

    public function user_profile(): HasOne
    {
        return $this->hasOne(UserProfile::class, 'user_profile');
    }
}
