<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{

    protected $table = 'm_employees';
    protected $primaryKey = 'id';
    protected $fillable = ['branch_id', 'position_id', 'name', 'email', 'phone', 'hire_date', 'status'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function performances()
    {
        return $this->hasMany(Performance::class);
    }
}