<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function branchName(): Attribute
    {
        return Attribute::make(get: fn($val, $atr) => Branch::find($atr['branch_id'])?->name);
    }
}
