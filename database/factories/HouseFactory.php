<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\House>
 */
class HouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();

        return [
            'name' => "小房子-" . Str::random(4),
            'owner_id' => $user->id,
            'price' => (int) Str::random(5),
            'shortest_rent_time' => '兩個月',
            'house_type_id' => rand(1, 4),
            'city_id' => 2,
        ];
    }
}
