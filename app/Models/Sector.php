<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function enrollees()
    {
        return $this->hasMany(Enrollee::class);
    }
}
