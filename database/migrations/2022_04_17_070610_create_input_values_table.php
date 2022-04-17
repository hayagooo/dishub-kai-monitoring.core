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
        Schema::create('monitoring_input_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('monitoring_input_id')->constrained('monitoring_inputs');
            $table->foreignId('monitoring_id')->constrained('monitorings');
            $table->string('string_value')->nullable();
            $table->date('date_value')->nullable();
            $table->time('time_value')->nullable();
            $table->float('number_value')->nullable();
            $table->string('file_value')->nullable();
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
        Schema::dropIfExists('input_values');
    }
};
