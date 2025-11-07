<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('employee_code')->nullable(); 
            $table->decimal('base_salary', 12, 2)->nullable();
            
            // Susun ulang kolom berdasarkan urutan yang Anda inginkan
            // dan hapus ->after()
            
            $table->string('phone_number')->nullable();
            $table->text('address')->nullable();
            $table->string('ktp_number')->nullable();
            $table->string('gender')->nullable(); // Bisa juga enum: ->enum('gender', ['male', 'female'])
            $table->date('birth_date')->nullable();
            
            // join_date akan ditempatkan setelah birth_date
            $table->date('join_date')->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
