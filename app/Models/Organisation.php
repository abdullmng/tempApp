<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function hmo()
    {
        return $this->belongsTo(Hmo::class);
    }

    public function hmoName(): Attribute
    {
        return Attribute::make(get: fn($val, $atts) => Hmo::where('id', $atts['hmo_id'])->first()?->name);
    }
}
