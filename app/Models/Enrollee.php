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
        return Attribute::make(get: fn($val, $cols) => $cols['first_name']. ' '. (!is_null($cols['middle_name']) ? substr($cols['middle_name'], 0, 1).'.': ''). ' ' . $cols['last_name']);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    /* public function sectorName(): Attribute
    {
        return Attribute::make(get: fn($val, $cols) => Sector::find($cols['sector_id'])?->name);
    } */

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    /* public function organisationName(): Attribute
    {
        return Attribute::make(get: fn($val, $cols) => Organisation::find($cols['organisation_id'])?->name);
    } */

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /* public function branchName(): Attribute
    {
        return Attribute::make(get: fn($val, $cols) => Branch::find($cols['branch_id'])?->name);
    } */

    public function category() 
    {
        return $this->belongsTo(Category::class);
    }

   /*  public function categoryName(): Attribute
    {
        return Attribute::make(get: fn($val, $cols) => Category::find($cols['category_id'])?->name);
    } */

    public function hcp()
    {
        return $this->belongsTo(Hcp::class);
    }

    /* public function hcpName(): Attribute
    {
        return Attribute::make(get: fn($val, $cols) => Hcp::find($cols['hcp_id'])?->name);
    } */

    public function blood_group()
    {
        return $this->belongsTo(BloodGroup::class);
    }

    /* public function bloodGroupName(): Attribute
    {
        return Attribute::make(get: fn($val, $cols) => BloodGroup::find($cols['blood_group_id'])?->name);
    } */

    public function updatedByUsername(): Attribute
    {
        return Attribute::make(get: fn($val, $cols) => User::where('id', $cols['updated_by'])->first()?->username);
    }

    public function enrolledByUsername(): Attribute
    {
        return Attribute::make(get: fn($val, $cols) => User::where('id', $cols['enrolled_by'])->first()?->username);
    }
}
