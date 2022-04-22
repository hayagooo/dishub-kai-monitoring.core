<?php

use App\Models\Monitoring\InputValue;
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
        Schema::table('monitoring_input_values', function (Blueprint $table) {
            $table->enum('type_file', InputValue::getAvailableExtension())->nullable()->after('file_value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monitoring_input_values', function (Blueprint $table) {
            //
        });
    }
};
