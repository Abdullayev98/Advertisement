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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->default(1);
            $table->string('description');
            $table->decimal('long', 10, 7);
            $table->decimal('lat', 10, 7);
            $table->bigInteger('sum');
            $table->bigInteger('phone');
            $table->boolean('free')->default(true);
            $table->string('image')->nullable();
            $table->foreignId('district_id')->constrained()->onDelete('cascade');
            $table->boolean('deleted')->default(true);
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
        Schema::dropIfExists('banners');
    }
};
