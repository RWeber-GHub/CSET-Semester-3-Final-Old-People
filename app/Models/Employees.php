<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;
    protected $table = 'employees';
    protected $primaryKey = 'EmployeeID';
    protected $fillable = [
        'UserID',
        'Salary',
        'Role',
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'UserID', 'UserID');
    }
}
