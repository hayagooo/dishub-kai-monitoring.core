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
        Schema::create('monitoring_inputs', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->enum('type', ['text', 'select', 'number', 'checkbox', 'radio']);
            $table->string('placeholder')->nullable();
            $table->string('text')->nullable();
            $table->float('number')->nullable();
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
        Schema::dropIfExists('monitoring_inputs');
    }
};
