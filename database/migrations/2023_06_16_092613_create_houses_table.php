<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $shortest_rent_time = ["一個月", "兩個月", "三個月", "四個月", "五個月", "半年", "一年", "兩年", "三年"];

        Schema::create('houses', function (Blueprint $table) use ($shortest_rent_time) {
            $table->id();
            $table->string('name');

            $table->unsignedBigInteger('owner_id');
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedInteger('price');
            $table->unsignedDecimal('size', $precision = 10, $scale = 1)->nullable();
            $table->enum('shortest_rent_time', $shortest_rent_time);
            
            $table->unsignedBigInteger('house_type_id');
            $table->foreign('house_type_id')->references('id')->on('house_types')->onDelete('cascade');

            $table->longText('description')->nullable();

            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            
            $table->unsignedBigInteger('city_dist_id')->nullable();
            $table->foreign('city_dist_id')->references('id')->on('city_dists')->onDelete('cascade');

            $table->string('address')->nullable();

            $table->boolean("can_cook")->default(false);
            $table->boolean("can_pet")->default(false);
            $table->boolean("near_stop")->default(false);
            $table->boolean("has_parking")->default(false);
            $table->boolean("has_elevator")->default(false);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};
