<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();  // id INT, PK, AUTO_INCREMENT
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            # Sẽ xóa bản ghi con khi bản ghi cha mất 
            // user_id INT, FK → users.id, NOT NULL
            $table->string('full_name', 255);  // VARCHAR(255), NOT NULL
            $table->string('student_id')->unique();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->timestamps();  // created_at, updated_at TIMESTAMP
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
