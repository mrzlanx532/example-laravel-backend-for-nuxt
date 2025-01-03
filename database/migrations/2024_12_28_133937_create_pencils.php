<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pencils', function (Blueprint $table) {
            $table->id();
            $table->boolean('example_checkbox')->nullable();
            $table->date('example_date')->nullable();
            $table->datetime('example_datetime')->nullable();
            $table->text('example_editor')->nullable();
            $table->string('example_input')->nullable();
            $table->string('example_input_file')->nullable();
            $table->unsignedBigInteger('example_select')->nullable();
            $table->json('example_select_wrap')->nullable();
            $table->string('example_switcher')->nullable();
            $table->text('example_textarea')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pencils');
    }
};
