<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    protected $casts = [
        'User_Group' => 'array',
    ];
    protected $table = 'users';
    protected $primaryKey = 'UserID';
    protected $fillable = [
        'RoleID',
        'First_Name',
        'Last_Name',
        'Email',
        'Phone',
        'Date_of_Birth',
        'Password',
        'Family_Code',
        'Emergency_Contact',
        'Emergency_Contact_Relation',
        'Approved',
        'User_Group',
        'created_at',
        'updated_at'
    ];

    public function patient()
    {
        return $this->hasOne(Patients::class, 'UserID', 'UserID');
    }

    public function employee()
    {
        return $this->hasOne(Employees::class, 'UserID', 'UserID');
    }
}
