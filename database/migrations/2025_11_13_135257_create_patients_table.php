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
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('PatientID');
            $table->unsignedInteger('UserID');
            $table->dateTime('Admission_Date')->nullable();

            $table->string('Family_Code', 10);
            $table->string('Relation', 20);
            $table->decimal('Amount_Due', 10, 2);

            $table->timestamps();

            $table->foreign('UserID')->references('UserID')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
