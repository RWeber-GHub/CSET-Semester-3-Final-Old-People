<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{
    protected $table = 'roster';
    protected $primaryKey = 'RosterID';
    public $timestamps = true;

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
        'Date' => 'datetime',
    ];

    public function supervisor()
    {
        return $this->belongsTo(Users::class, 'SupervisorID', 'UserID');
    }

    public function doctor()
    {
        return $this->belongsTo(Users::class, 'DoctorID', 'UserID');
    }

    public function cg1()
    {
        return $this->belongsTo(Users::class, 'Caregiver1_ID', 'UserID');
    }

    public function cg2()
    {
        return $this->belongsTo(Users::class, 'Caregiver2_ID', 'UserID');
    }

    public function cg3()
    {
        return $this->belongsTo(Users::class, 'Caregiver3_ID', 'UserID');
    }

    public function cg4()
    {
        return $this->belongsTo(Users::class, 'Caregiver4_ID', 'UserID');
    }
}
