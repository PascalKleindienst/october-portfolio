<?php namespace PKleindienst\Portfolio\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateTagsTable extends Migration
{
    public function up()
    {
        Schema::create('pkleindienst_portfolio_tags', function($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('pkleindienst_portfolio_items_tags', function($table) {
            $table->engine = 'InnoDB';
            $table->integer('tag_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->primary([ 'item_id', 'category_id' ]);
            $table->foreign('tag_id')->references('id')->on('pkleindienst_portfolio_tags')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('pkleindienst_portfolio_items')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pkleindienst_portfolio_tags');
        Schema::dropIfExists('pkleindienst_portfolio_items_tags');
    }
}
