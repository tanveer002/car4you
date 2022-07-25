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
        Schema::create('user_products_deliveries', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('variant_value_id')
                ->constrained('variant_values')
                ->cascadeOnDelete();

            $table->string('product_name')->nullable();
            $table->string('product_model')->nullable();

            $table->foreignId('location_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->longText('comments')->nullable();

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
        Schema::dropIfExists('user_products_deliveries');
    }
};
