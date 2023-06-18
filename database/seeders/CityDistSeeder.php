<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\CityDist;

class CityDistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 1;
        $city_file = storage_path("csv/tw_city_dist.csv");
        $cities = [];

        if (($f = fopen($city_file, "r")) !== FALSE) {
            // 1. fetch data from csv
            while (($data = fgetcsv($f, 1000, ",")) !== FALSE) {
                if ($row === 1) { $row++; }

                else {
                    $id = $data[0];
                    $name = $data[1];
                    $city_id = $data[2];
                    $cities[] = ['id' => $id, 'dist_name' => $name, 'city_id' => $city_id];
                }
            }
            fclose($f);

            // 2. insert into database
            CityDist::upsert($cities, 'id');
        }
    }
}
