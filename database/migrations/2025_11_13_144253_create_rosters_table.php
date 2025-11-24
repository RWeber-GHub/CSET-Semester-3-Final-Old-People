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
        Schema::create('roster', function (Blueprint $table) {
            $table->increments('RosterID');
            $table->dateTime('Date');
            $table->unsignedInteger('SupervisorID');
            $table->unsignedInteger('DoctorID');
            $table->unsignedInteger('Caregiver1_ID');
            $table->unsignedInteger('Caregiver2_ID');
            $table->unsignedInteger('Caregiver3_ID');
            $table->unsignedInteger('Caregiver4_ID');
            $table->timestamps();

            $table->foreign('SupervisorID')->references('UserID')->on('users');
            $table->foreign('DoctorID')->references('UserID')->on('users');
            $table->foreign('Caregiver1_ID')->references('UserID')->on('users');
            $table->foreign('Caregiver2_ID')->references('UserID')->on('users');
            $table->foreign('Caregiver3_ID')->references('UserID')->on('users');
            $table->foreign('Caregiver4_ID')->references('UserID')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rosters');
    }
};
