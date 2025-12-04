<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{
    protected $table = 'roster';

    protected $fillable = [
        'Date',
        'SupervisorID',
        'DoctorID',
        'Caregiver1_ID',
        'Caregiver2_ID',
        'Caregiver3_ID',
        'Caregiver4_ID',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Relationships to User model (adjust User primaryKey if necessary)
public function supervisor()
{
    return $this->belongsTo(Users::class, 'SupervisorID');
}

public function doctor()
{
    return $this->belongsTo(Users::class, 'DoctorID');
}

public function cg1()
{
    return $this->belongsTo(Users::class, 'CG1_ID');
}

public function cg2()
{
    return $this->belongsTo(Users::class, 'CG2_ID');
}

public function cg3()
{
    return $this->belongsTo(Users::class, 'CG3_ID');
}

public function cg4()
{
    return $this->belongsTo(Users::class, 'CG4_ID');
}

}
