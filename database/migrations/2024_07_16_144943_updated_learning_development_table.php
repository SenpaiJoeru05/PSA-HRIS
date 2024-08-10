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
        Schema::table('learning_development', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'learningdev_from_date',
                'learningdev_to_date',
                'learningdev_hours',
                'learningdev_type',
                'learningdev_conducted_by',
            ]);
            $table->json('learning_development_experiences_data')->nullable();
            $table->boolean('learning_development_not_applicable')->default(false);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('learning_development', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->date('learningdev_from_date')->nullable();
            $table->date('learningdev_to_date')->nullable();
            $table->integer('learningdev_hours')->nullable();
            $table->string('learningdev_type')->nullable();
            $table->string('learningdev_conducted_by')->nullable();

            $table->dropColumn('learning_development_experiences_data');
        });
    }
};
