<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

use App\Models\User;
use App\Models\House;

class HouseControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate');
    }

    public function test_houses_index()
    {
        $res = $this->get('/api/houses');

        $res->assertStatus(200);
    }

    public function test_houses_index_owner_without_login()
    {
        $res = $this->get('/api/users/1/houses');

        // redirect to login route since not login
        $res->assertStatus(302);
    }

    public function test_houses_index_owner()
    {
        $owner = User::factory()->create();

        $res = $this->actingAs($owner)->get("/api/users/$owner->id/houses");

        $res->assertStatus(200);
    }

    public function test_houses_store()
    {
        $owner = User::factory()->create();

        $data = [
            'name' => "小套房", 'owner_id' => $owner->id, 'price' => 10000,
            'shortest_rent_time' => "三個月", "house_type_id" => 2, "city_id" => 1,
            "near_stop" => true,
            "reservations" => ["14:00", "15:00"]
        ];

        $res = $this->actingAs($owner)
            ->postJson('/api/houses', $data);

        $res->assertStatus(200);
    }

    public function test_house_show()
    {
        $res = $this->get('/api/houses/1');

        $res->assertStatus(200);
    }

    public function test_house_update()
    {
        $house = House::factory()->create();
        $user = User::where('id', $house->owner_id)->first();

        $data = ["name" => "破爛小屋，沒錢", "price" => 3400];

        $res = $this->actingAs($user)->patchJson("/api/houses/$house->id", $data);

        $res->assertStatus(200);
    }

    public function test_house_destroy()
    {
        $house = House::factory()->create();
        $user = User::where('id', $house->owner_id)->first();

        $res = $this->actingAs($user)->delete("/api/houses/$house->id");

        $res->assertStatus(200);
    }

    public function tearDown(): void
    {
        Artisan::call('migrate:refresh');

        parent::tearDown();
    }
}
