<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('travel_package_id')->constrained()->onDelete('cascade');
            $table->string('name', 100)->unique();
            $table->string('slug')->index();
            $table->integer('uploaded_by');
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
        Schema::dropIfExists('travel_galleries');
    }
}
