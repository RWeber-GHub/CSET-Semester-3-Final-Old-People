<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientHomeActivity extends Model
{
    use HasFactory;
    protected $table = 'patient_home_activity';
    protected $primaryKey = 'ActivityID';
    protected $fillable = [
        'PatientID',
        'DoctorID',
        'CaregiverID',
        'Comments',
        'Appointment',
        'Morning_Meds',
        'Afternoon_Meds',
        'Nighttime_Meds',
        'Breakfast',
        'Lunch',
        'Dinner',
    ];

    public function patient()
    {
        return $this->belongsTo(Patients::class, 'PatientID', 'PatientID');
    }
}
