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
        Schema::create('fee_structures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->string('fee_head'); // e.g., "Tuition Fee", "Library Fee", "Lab Fee"
            $table->decimal('amount', 10, 2);
            $table->enum('fee_type', ['Monthly', 'Quarterly', 'Half-Yearly', 'Yearly', 'One-Time'])->default('Yearly');
            $table->enum('frequency', ['One-Time', 'Monthly', 'Quarterly', 'Yearly'])->default('One-Time');
            $table->boolean('is_mandatory')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_structures');
    }
};
