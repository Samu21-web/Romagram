<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = ['name', 'slug', 'price', 'duration_days', 'description', 'is_active'];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}