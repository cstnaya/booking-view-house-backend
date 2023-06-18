<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use Mockery;
use Mockery\MockInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Http\Repositories\HouseRepository;
use App\Http\Caches\HouseCache;
use App\Http\Caches\HouseNullObject;
use App\Models\House;
use App\Models\User;

class HouseRepositoryTest extends TestCase
{
    private $user;
    private $houseData;

    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate');

        // arrange
        $this->user = User::factory()->create();
        $this->houseData = [
            "name" => "test house",
            "owner_id" => $this->user->id,
            "price" => 100,
            "shortest_rent_time" => "一個月",
            "house_type_id" => 1,
            "city_id" => 2,
            "city_dist_id" => 1,
            "can_pet" => true
        ];
    }

    public function test_insertHouseData(): void
    {
        // act
        $cache = Mockery::mock(HouseCache::class);
        $repo = new HouseRepository($cache);

        $res = $repo->insertHouseData($this->houseData);

        // assert
        $this->assertEquals($res->name, $this->houseData["name"]);
    }

    public function test_getHousesByQuery(): void
    {
        $datas = [
            [
                "name" => "近南港分租套房，捷運五分鐘可到", 'owner_id' => $this->user->id,
                "price" => 9000, "shortest_rent_time" => "一個月", "house_type_id" => 1,
                "has_parking" => true, "city_id" => 2, 'city_dist_id' => 3,
            ],
            [ // name not match
                "name" => "美麗之屋", 'owner_id' => $this->user->id,
                "price" => 7000, "shortest_rent_time" => "一個月", "house_type_id" => 1,
                "has_parking" => true,  "city_id" => 2, 'city_dist_id' => 1,
            ],
            [ // parking not match
                "name" => "水鄉澤國台北橋站捷運附近", 'owner_id' => $this->user->id,
                "price" => 4500, "shortest_rent_time" => "一個月", 'house_type_id' => 1,
                "has_parking" => false, "city_id" => 2, 'city_dist_id' => 5
            ],
            [ // city not match
                "name" => "水鄉澤國台北橋站捷運附近", 'owner_id' => $this->user->id,
                "price" => 9000, "shortest_rent_time" => "一個月", "house_type_id" => 1,
                "has_parking" => true, "city_id" => 1, 'city_dist_id' => 1
            ],
            [ // house type not match
                "name" => "租屋會館南展捷運站環繞", 'owner_id' => $this->user->id,
                "price" => 7000, "shortest_rent_time" => "一個月", "house_type_id" => 3,
                "has_parking" => true, "city_id" => 2, 'city_dist_id' => 2
            ],
            [ // price not match
                "name" => "租屋會館南展捷運站環繞", 'owner_id' => $this->user->id,
                "price" => 27000, "shortest_rent_time" => "一個月", "house_type_id" => 1,
                "has_parking" => true, "city_id" => 2, 'city_dist_id' => 4
            ],
        ];
        House::insert($datas);  // 每列的欄位要完全一致才能使用

        // 想找有車位、名稱包含捷運、台北市、價格小於 9000 的套房
        $query = [
            'parking' => true,
            'keyword' => "捷運",
            'house_type' => 1,
            'city' => 2,
            'price_max' => 9000,
        ];

        $cache = Mockery::mock(HouseCache::class);
        $repo = new HouseRepository($cache);
        $res = $repo->getHousesByQuery($query);

        $this->assertEquals(1, count($res));
    }

    public function test_getHouseById(): void
    {
        $house = House::create($this->houseData);

        $cache = Mockery::mock(HouseCache::class);
        $cache->shouldReceive('getHouseCache')->once()->andReturn(null);
        $cache->shouldReceive('putHouseCache')->once();

        $repo = new HouseRepository($cache);

        $res = $repo->getHouseById($house->id);

        $this->assertEquals($res->name, $this->houseData["name"]);
    }


    // TODO: putNullObject(), but no expectations were specified
    public function _getHouseById_twice(): void
    {
        $house = House::factory()->create();

        $cache = Mockery::mock(HouseCache::class);
        $cache->shouldReceive('getHouseCache')->once()->andReturn(null);
        $cache->shouldReceive('putHouseCache')->once();

        $repo = new HouseRepository($cache);

        // the first time to get data
        $repo->getHouseById($house->id);

        // the second thime to get data (by cache)
        $cache->shouldReceive('getHouseCache')->once()->andReturn($house);
        $res = $repo->getHouseById($house->id);

        $this->assertEquals($house, $res);
    }

    public function test_updateHouseById(): void
    {
        $house = House::create($this->houseData);
        $newData = ['price' => 15000, 'name' => "豪美大豪宅"];

        $cache = Mockery::mock(HouseCache::class);
        $cache->shouldReceive('clearHouseCache')->once();

        $repo = new HouseRepository($cache);

        $res = $repo->updateHouseById(
            $house->id,
            $newData
        );

        $this->assertEquals(true, $res);
    }

    public function test_destroyById(): void
    {
        $house = House::create($this->houseData);

        $cache = Mockery::mock(HouseCache::class);
        $cache->shouldReceive('clearHouseCache')->once();

        $repo = new HouseRepository($cache);

        $res = $repo->destroyById($house->id);

        $this->assertEquals(true, $res);
    }

    public function tearDown(): void
    {
        Artisan::call('migrate:refresh');

        parent::tearDown();
    }
}
