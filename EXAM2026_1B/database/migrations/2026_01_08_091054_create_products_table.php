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
        Schema::create('products', function (Blueprint $table) {
            $table->id();  // id INT, PK, AUTO_INCREMENT
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            # Sẽ xóa bản ghi con khi bản ghi cha mất 
            // user_id INT, FK → users.id, NOT NULL
            $table->string('name', 255);  // VARCHAR(255), NOT NULL
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->timestamps();  // created_at, updated_at TIMESTAMP
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
