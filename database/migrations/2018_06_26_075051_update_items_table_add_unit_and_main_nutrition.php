<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateItemsTableAddUnitAndMainNutrition extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function(Blueprint $table){
            $table->string('unit')->after('price');
            $table->string('nutrition')->after('description');
            $table->dropColumn('qty');
            $table->integer('stock')->default(0)->after('unit');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function(Blueprint $table){
            $table->dropColumn('unit');
            $table->dropColumn('nutrition');
            $table->integer('qty')->default(0);
            $table->dropColumn('stock');
        });
    }
}
