<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

use Database\Seeders\CitySeeder;
use Database\Seeders\CityDistSeeder;

use App\Models\City;
use App\Models\CityDist;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // city
        $seeder = new CitySeeder();
        $seeder->run();

        // city dists
        $seeder = new CityDistSeeder();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // remove ALL data and reset auto-increase IDs to 1
        Schema::disableForeignKeyConstraints();
        CityDist::truncate();
        City::truncate();
        Schema::enableForeignKeyConstraints();
    }
};
