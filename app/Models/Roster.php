<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{
    protected $table = 'roster';

    protected $fillable = [
        'date',
        'supervisor_id',
        'doctor_id',
        'caregiver1_id',
        'caregiver2_id',
        'caregiver3_id',
        'caregiver4_id',
        'patient_group1',
        'patient_group2',
        'patient_group3',
        'patient_group4',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Relationships to User model (adjust User primaryKey if necessary)
    public function supervisor() { return $this->belongsTo(\App\Models\Users::class, 'supervisor_id', 'UserID'); }
    public function doctor()     { return $this->belongsTo(\App\Models\Users::class, 'doctor_id', 'UserID'); }
    public function cg1()        { return $this->belongsTo(\App\Models\Users::class, 'caregiver1_id', 'UserID'); }
    public function cg2()        { return $this->belongsTo(\App\Models\Users::class, 'caregiver2_id', 'UserID'); }
    public function cg3()        { return $this->belongsTo(\App\Models\Users::class, 'caregiver3_id', 'UserID'); }
    public function cg4()        { return $this->belongsTo(\App\Models\Users::class, 'caregiver4_id', 'UserID'); }
}
