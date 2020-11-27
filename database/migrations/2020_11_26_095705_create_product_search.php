<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSearch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('product_search', function (Blueprint $table) {
            $table->bigIncrements('product_search_id');
            $table->engine = 'MyISAM';
            $table->integer('product_id');
            $table->text('product_body');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE product_search ADD FULLTEXT search(product_body)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_search');
    }
}
