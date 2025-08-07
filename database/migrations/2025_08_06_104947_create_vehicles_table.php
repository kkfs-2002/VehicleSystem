<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->decimal('price', 10, 2);
            $table->text('details')->nullable();
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            $table->integer('mileage')->default(0);
            $table->string('color')->nullable();
            $table->string('fuel');
            $table->string('transmission');
            $table->integer('seats');
            $table->boolean('approved')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}