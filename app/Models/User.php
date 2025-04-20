<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'm_user';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'email', 'password', 'role', 'branch_id'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Performance::class, 'evaluator_id');
    }
}
