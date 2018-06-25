<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateItemTableAddDesc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function(Blueprint $table){
            $table->string('description')->nullable()->default(null)->after('category');
            $table->string('img')->nullable()->default(null)->after('description');
            $table->dropColumn('stock');
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
            $table->integer('stock')->nullable()->default(null)->after('qty');
            $table->dropColumn('description');
            $table->dropColumn('img');
        });
    }
}
