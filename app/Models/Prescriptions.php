<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescriptions extends Model
{
    use HasFactory;
    protected $table = 'prescriptions';
    protected $primaryKey = 'PrescriptionID';
    protected $fillable = [
        'DoctorID',
        'PatientID',
        'AppointmentID',
        'Date',
        'Prescription_Details',
    ];
    
    public function patient()
    {
        return $this->belongsTo(Patients::class, 'PatientID', 'PatientID');
    }
    
}
