<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperimentResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experiment_results', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('experiment_id');

            $table->foreign('experiment_id')
                ->references('id')
                ->on('experiments')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->integer('leads_count')->default(0);
            $table->integer('opportunities_count')->default(0);
            $table->float('opportunities_value')->default(0.0);
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
        Schema::dropIfExists('experiment_results', function (Blueprint $table) {
            $table->dropForeign(['experiment_id']);
        });
    }
}
