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
            $table->dropForeign(['color_id']);
            $table->foreign('color_id')
                ->references('id')
                ->on('colors')
                ->onDelete('cascade');
            
            $table->dropForeign(['size_id']);
            $table->foreign('size_id')
                ->references('id')
                ->on('sizes')
                ->onDelete('cascade');
            
            $table->dropForeign(['condition_id']);
            $table->foreign('condition_id')
                ->references('id')
                ->on('conditions')
                ->onDelete('cascade');

            $table->dropForeign(['material_id']);
            $table->foreign('material_id')
                ->references('id')
                ->on('materials')
                ->onDelete('cascade');

            $table->dropForeign(['section_id']);
            $table->foreign('section_id')
                ->references('id')
                ->on('sections')
                ->onDelete('cascade');
            
            $table->dropForeign(['branch_id']);
            $table->foreign('branch_id')
                ->references('id')
                ->on('branches')
                ->onDelete('cascade');
            
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
