<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patient_home_activity', function (Blueprint $table) {
            $table->increments('ActivityID');
            $table->unsignedInteger('PatientID');
            $table->unsignedInteger('DoctorID')->nullable();
            $table->unsignedInteger('CaregiverID')->nullable();
            $table->dateTime('Date');
            $table->string('Comments', 255)->nullable();
            $table->boolean('Appointment')->default(false);
            $table->boolean('Morning_Meds')->default(false);
            $table->boolean('Afternoon_Meds')->default(false);
            $table->boolean('Nighttime_Meds')->default(false);
            $table->boolean('Breakfast')->default(false);
            $table->boolean('Lunch')->default(false);
            $table->boolean('Dinner')->default(false);
            $table->timestamps();

            $table->foreign('PatientID')->references('PatientID')->on('patients');
            $table->foreign('DoctorID')->references('UserID')->on('users');
            $table->foreign('CaregiverID')->references('UserID')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_home_activity');
    }
};
