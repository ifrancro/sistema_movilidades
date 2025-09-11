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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('license_number')->unique();
            $table->date('license_expiry');
            $table->enum('license_category', ['A', 'B', 'C', 'D', 'E'])->default('B');
            $table->enum('status', ['active', 'inactive', 'suspended', 'expired'])->default('active');
            $table->date('hire_date');
            $table->decimal('salary', 10, 2)->nullable();
            $table->text('emergency_contact')->nullable();
            $table->text('medical_certificate')->nullable();
            $table->date('medical_expiry')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
