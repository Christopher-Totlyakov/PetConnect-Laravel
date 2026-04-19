<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PetPostLike extends Model
{
    protected $fillable = [
        'post_id',
        'user_id'
    ];

    public function likes()
    {
        return $this->hasMany(PetPostLike::class, 'post_id');
    }
}
