<?php

use App\Models\Monitoring\Input;
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
            $table->foreignId('monitoring_id')->constrained('monitorings');
            $table->string('label');
            $table->enum('type', Input::getAvailableType());
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
