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

            $table->integer('leads_count')->default(0);
            $table->integer('won_opportunities_count')->default(0);
            $table->decimal('won_opportunities_annual_value', 10, 2)->default(0.0);
            $table->integer('open_opportunities_count')->default(0);
            $table->decimal('open_opportunities_annual_value', 10, 2)->default(0.0);
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
