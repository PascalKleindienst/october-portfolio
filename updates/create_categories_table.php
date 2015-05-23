<?php namespace PKleindienst\Portfolio\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('pkleindienst_portfolio_categories', function($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->index();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('pkleindienst_portfolio_items_categories', function($table) {
            $table->engine = 'InnoDB';
            $table->integer('item_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->primary(['item_id', 'category_id']);
        });
    }

    public function down()
    {
        Schema::drop('pkleindienst_portfolio_categories');
        Schema::drop('pkleindienst_portfolio_items_categories');
    }
}
