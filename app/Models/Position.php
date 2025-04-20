<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'm_poritions';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'description'];

    public function employees()
    {
        return $this->hasMany(Employees::class);
    }
}
