<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('category_product');

        Schema::create('category_product', function (Blueprint $table) {
          

            $table->foreignId('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
           
            $table->foreignId('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
