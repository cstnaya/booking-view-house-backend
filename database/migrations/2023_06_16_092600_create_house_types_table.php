<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\HouseType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // create table
        Schema::create('house_types', function (Blueprint $table) {
            $table->id();
            $table->string('house_type');
        });

        // insert data
        $house_types = [
            ["id" => 1, "house_type" => "獨立套房"], 
            ["id" => 2, "house_type" => "雅房"], 
            ["id" => 3, "house_type" => "合租家庭房"], 
            ["id" => 4, "house_type" => "辦公大樓"], 
        ];
        HouseType::upsert($house_types, 'id');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house_types');
    }
};
