<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('users')->cascadeOnDelete();
            $table->string('employee_code')->nullable(); 
            $table->decimal('base_salary', 12, 2)->nullable();
            $table->string('phone_number')->nullable();
            $table->text('address')->nullable();
            $table->string('ktp_number')->nullable();
            $table->string('gender')->nullable(); 
            $table->date('birth_date')->nullable();
            $table->date('join_date')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
