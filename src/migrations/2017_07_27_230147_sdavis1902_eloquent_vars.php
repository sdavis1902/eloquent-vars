<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Sdavis1902EloquentVars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_vars', function($table) {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->integer('model_id')->unsigned();
            $table->string('table', 255);
            $table->string('key', 255);
            $table->text('value')->nullable();
            $table->timestamps();

            // Add indexes for better performance
            $table->index(['model_id', 'table']);
            $table->index(['model_id', 'table', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('model_vars');
    }
}
