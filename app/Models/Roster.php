<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{
    use HasFactory;
    protected $table = 'roster';
    protected $primaryKey = 'RosterID';
    protected $fillable = [
        'Date',
        'SupervisorID',
        'DoctorID',
        'Caregiver1_ID',
        'Caregiver2_ID',
        'Caregiver3_ID',
        'Caregiver4_ID',
    ];
    
}
