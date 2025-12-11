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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('UserID');
            $table->unsignedInteger('RoleID');
            $table->string('First_Name', 25);
            $table->string('Last_Name', 25);
            $table->string('Email', 35)->unique();
            $table->string('Phone', 12)->nullable();
            $table->date('Date_of_Birth')->nullable();
            $table->string('Password', 50);
            $table->string('Family_Code', 10)->nullable();
            $table->string('Emergency_Contact', 15)->nullable();
            $table->string('Emergency_Contact_Relation', 20)->nullable();
            $table->boolean('Approved')->default(false);

            $table->json('User_Group')->nullable();
            

            $table->timestamps();

            $table->foreign('RoleID')->references('RoleID')->on('roles');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
