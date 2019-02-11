<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperimentExperimentVariableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experiment_experiment_variable', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('experiment_id')->unsigned();
            $table->foreign('experiment_id')
                ->references('id')
                ->on('experiments')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->integer('experiment_variable_id')->unsigned();
            $table->foreign('experiment_variable_id')
                ->references('id')
                ->on('experiment_variables')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('experiment_experiment_variable');
    }
}
