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
            $table->foreignId('monitoring_category_id')->constrained('monitoring_categories');
            $table->foreignId('monitoring_object_id')->nullable()->constrained('monitoring_objects');
            $table->foreignId('monitoring_id')->nullable()->constrained('monitorings');
            $table->string('image')->nullable();
            $table->boolean('is_required')->default(1)->nullable();
            $table->string('label');
            $table->string('link')->nullable();
            $table->enum('type', Input::getAvailableType());
            $table->string('placeholder')->nullable();
            $table->longText('description')->nullable();
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
