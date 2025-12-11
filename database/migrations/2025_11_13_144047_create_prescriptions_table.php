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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->increments('PrescriptionID');
            $table->unsignedInteger('DoctorID');
            $table->unsignedInteger('PatientID');
            $table->unsignedInteger('AppointmentID');
            $table->dateTime('Date');
            $table->string('Prescription_Details', 255)->nullable();
            $table->timestamps();

            $table->foreign('DoctorID')->references('UserID')->on('users');
            $table->foreign('PatientID')->references('PatientID')->on('patients');
            $table->foreign('AppointmentID')->references('AppointmentID')->on('appointments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
