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
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('AppointmentID');
            $table->unsignedInteger('DoctorID');
            $table->unsignedInteger('PatientID');
            $table->dateTime('Date');
            $table->string('Status', 25);
            $table->timestamps();
            
            $table->foreign('DoctorID')
                  ->references('UserID')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('PatientID')
                  ->references('PatientID')
                  ->on('patients')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
