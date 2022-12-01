<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_packages', function (Blueprint $table) {
            $table->id();
            $table->string('title', 55)->unique();
            $table->string('slug')->index();
            $table->string('location', 75);
            $table->longText('about');
            $table->string('featured_event', 150);
            $table->string('language', 75);
            $table->string('foods', 150);
            $table->dateTime('date_departure')->index();
            $table->integer('duration');
            $table->dateTime('date_completion')->index();
            $table->enum('type', ['Open Trip', 'Private Group']);
            $table->bigInteger('price');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('travel_packages');
    }
}
