<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hcp extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function organisationName(): Attribute
    {
        return Attribute::make(get: fn($val, $cols) => Organisation::where('id', $cols['organisation_id'])->first()?->name);
    }
}
