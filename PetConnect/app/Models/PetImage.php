<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PetImage extends Model
{
    protected $fillable = [
        'path',
        'post_id'
    ];

    public function pet()
    {
        return $this->hasOne(Pet::class, 'image_id');
    }

    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }
}
