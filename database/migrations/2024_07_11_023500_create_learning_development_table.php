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
        Schema::create('learning_development', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->date('learningdev_from_date')->nullable();
            $table->date('learningdev_to_date')->nullable();
            $table->string('learningdev_hours')->nullable();
            $table->string('learningdev_type')->nullable();
            $table->string('learningdev_conducted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_development');
    }
};
