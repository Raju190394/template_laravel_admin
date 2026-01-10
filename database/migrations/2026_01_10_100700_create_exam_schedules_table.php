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
        Schema::create('exam_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade'); // Subject
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('full_marks')->default(100);
            $table->integer('pass_marks')->default(40);
            $table->string('room_no')->nullable();
            $table->timestamps();
            
            // Prevent duplicate schedule for same class+subject in an exam
            $table->unique(['exam_id', 'class_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_schedules');
    }
};
