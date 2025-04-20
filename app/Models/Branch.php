<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{

    protected $table = 'm_branches';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'address', 'city', 'phone'];

    public function employees()
    {
        return $this->hasMany(Employees::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}