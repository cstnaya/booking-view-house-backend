<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 1;
        $city_file = storage_path("csv/tw_city.csv");
        $cities = [];

        if (($f = fopen($city_file, "r")) !== FALSE) {
            // 1. fetch data from csv
            while (($data = fgetcsv($f, 1000, ",")) !== FALSE) {
                if ($row === 1) { $row++; }

                else {
                    $id = $data[0];
                    $city = $data[1];
                    $cities[] = ['id' => $id, 'city' => $city];
                }
            }
            fclose($f);

            // 2. insert into database
            City::upsert($cities, 'id');
        }
    }
}
