<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    protected $table = 'm_performance';
    protected $primaryKey = 'id';
    protected $fillable = ['employee_id', 'evaluator_id', 'score', 'notes', 'evaluation_date'];

    public function employee()
    {
        return $this->belongsTo(Employees::class);
    }

    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }
}
