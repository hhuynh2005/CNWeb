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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();  // Tạo cột id INT, PK, AUTO_INCREMENT
            $table->string('name', 100)->unique();  // VARCHAR(100), UNIQUE
            $table->string('address', 100);  // VARCHAR(100), UNIQUE
            $table->string('phone', 255);         // VARCHAR(255)      
            $table->timestamps();  // created_at, updated_at TIMESTAMP
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
