<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserProfile extends Model
{
    protected $table = 'user_profile';

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'bio',
        'date_of_birth',
        'gender',
        'contact_info',
        'status',
        'role_id',
        'user_id',
        'address_id',
    ];

    public function address(): HasOne
    {
        return $this->hasOne(Address::class, 'address');
    }
}
