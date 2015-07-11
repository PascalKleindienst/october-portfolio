<?php namespace PKleindienst\Portfolio\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * Items Schema
 * @package PKleindienst\Portfolio\Updates
 */
class CreateItemsTable extends Migration
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        Schema::create('pkleindienst_portfolio_items', function($table) {
            $table->engine = 'InnoDB';
            $table->unsigned()->increments('id');
            $table->string('title')->nullable();
            $table->string('slug')->unique();
            $table->text('content')->nullable();
            $table->string('tagline')->nullable();
            $table->text('description')->nullable();
            $table->string('website')->nullable();
            $table->date('date')->nullable();
            $table->enum('visibility', [ 'public', 'private' ])->default('public');
            $table->timestamps();
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        Schema::drop('pkleindienst_portfolio_items');
    }
}
