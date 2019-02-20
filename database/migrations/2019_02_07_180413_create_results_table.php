<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('experiment_id');

            $table->foreign('experiment_id')
                ->references('id')
                ->on('experiments')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->json('data');
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
        Schema::dropIfExists('results', function (Blueprint $table) {
            $table->dropForeign(['experiment_id']);
        });
    }
}
