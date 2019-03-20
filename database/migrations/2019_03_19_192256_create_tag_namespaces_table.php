<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagNamespacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag_namespaces', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->unsignedInteger('namespace_id')->nullable();

            $table->foreign('namespace_id')
                ->references('id')
                ->on('tag_namespaces')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('full_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn(['namespace_id', 'full_name']);
        });

        Schema::dropIfExists('tag_namespaces');
    }
}
