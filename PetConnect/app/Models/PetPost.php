<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PetPost extends Model
{
    protected $fillable = [
        'pet_id',
        'title',
        'content'
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function image()
    {
        return $this->hasOne(PetImage::class, 'post_id');
    }

    public function comments()
    {
        return $this->hasMany(PetPostComment::class, 'post_id');
    }

    public function likes()
    {
        return $this->hasMany(PetPostLike::class, 'post_id');
    }
}
