<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    use HasFactory;
    protected $table = 'patients';
    protected $primaryKey = 'PatientID';
    protected $fillable = [
        'Admission_Date',
        'UserID',
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'UserID', 'UserID');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescriptions::class, 'PatientID', 'PatientID');
    }

    public function activity()
    {
        return $this->hasMany(PatientHomeActivity::class, 'PatientID', 'PatientID');
    }
}
