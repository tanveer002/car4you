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
        Schema::table('c_models', function($table) {
            $table->dropForeign('c_models_car_id_foreign');
        });
        Schema::table('car_models', function($table) {
            $table->dropForeign('car_models_car_id_foreign');
            $table->dropForeign('car_models_c_model_id_foreign');
        });

        Schema::drop('c_models'); // drop c_models table
        Schema::drop('car_models'); // drop car_models table
        Schema::drop('cars'); // drop cars table
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
