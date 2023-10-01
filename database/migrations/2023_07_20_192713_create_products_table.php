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
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price')->default(0.00);
            $table->foreignId('color_id')->constrained();
            $table->foreignId('size_id')->constrained();
            $table->foreignId('condition_id')->constrained();
            $table->foreignId('material_id')->constrained();
            $table->foreignId('section_id')->constrained();
            $table->foreignId('branch_id')->constrained();
            $table->string('location')->nullable();
            $table->tinyInteger('is_for_sale')->default(1);
            $table->foreignId('user_id')->constrained();
            $table->enum('status',['rent','sale','available','not_available']);
            $table->string('sku')->nullable();
            $table->softDeletes();
            $table->timestamps();
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
