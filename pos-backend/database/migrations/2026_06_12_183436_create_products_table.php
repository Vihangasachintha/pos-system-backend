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
        Schema::create('products', function (Blueprint $table) {
            $table->id();                              // Auto-increment primary key
            $table->string('name');                    // Product name
            $table->text('description')->nullable();   // Optional description
            $table->string('sku')->unique();           // Stock keeping unit (unique code)
            $table->decimal('price', 10, 2);           // Price e.g. 1500.00
            $table->integer('stock')->default(0);      // Stock quantity
            $table->string('category')->nullable();    // e.g. "Electronics"
            $table->boolean('is_active')->default(true); // Active/inactive toggle
            $table->timestamps();                      // created_at & updated_at
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
