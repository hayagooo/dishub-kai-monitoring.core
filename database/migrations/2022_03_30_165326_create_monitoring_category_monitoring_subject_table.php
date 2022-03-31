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
        Schema::create('monitoring_category_subject', function (Blueprint $table) {
            $table->id();
            $table->foreignId('monitoring_category_id')->constrained('monitoring_categories');
            $table->foreignId('monitoring_object_id')->constrained('monitoring_objects');
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
        Schema::dropIfExists('monitoring_category_monitoring_subject');
    }
};
