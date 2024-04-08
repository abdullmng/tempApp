<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollee extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function fullName(): Attribute
    {
        return Attribute::make(get: fn($val, $cols) => $cols['first_name']. ' '. $cols['middle_name']. ' ' . $cols['last_name']);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function category() 
    {
        return $this->belongsTo(Category::class);
    }

    public function hcp()
    {
        return $this->belongsTo(Hcp::class);
    }

    public function updatedByUsername(): Attribute
    {
        return Attribute::make(get: fn($val, $cols) => User::where('id', $cols['updated_by'])->first()?->username);
    }
}
