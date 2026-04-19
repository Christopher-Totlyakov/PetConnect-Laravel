<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'user_id',
        'type_id',
        'name',
        'age',
        'description',
        'image_id'
    ];

    public function type()
    {
        return $this->belongsTo(PetType::class, 'type_id');
    }

    public function image()
    {
        return $this->belongsTo(PetImage::class, 'image_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->hasMany(PetPost::class);
    }
}
