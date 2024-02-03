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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('buy_price')->default(0.00);
            $table->decimal('sell_price')->default(0.00);
            $table->unsignedBigInteger('season_id')->nullable();
            $table->foreign('season_id')
                ->references('id')
                ->on('seasons')
                ->onDelete('cascade');
            $table->unsignedBigInteger('style_id')->nullable();
            $table->foreign('style_id')
                ->references('id')
                ->on('styles')
                ->onDelete('cascade');
            $table->string('barcode')->nullable();
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
