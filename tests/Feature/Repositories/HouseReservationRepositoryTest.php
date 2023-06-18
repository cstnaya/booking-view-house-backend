<?php

namespace Tests\Feature\Repositories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

use App\Http\Repositories\HouseReservationRepository;

use App\Models\HouseReservation;
use App\Models\House;
use App\Models\User;
use App\Models\Order;

use Carbon\Carbon;

class HouseReservationRepositoryTest extends TestCase
{
    private $repo;

    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate');

        $this->repo = new HouseReservationRepository();
    }

    public function test_insertMultipleReservationData(): void
    {
        $house = House::factory()->create();

        $data = [
            ['house_id' => $house->id, 'time' => Carbon::parse('15:00')],
            ['house_id' => $house->id, 'time' => Carbon::parse('19:00')],
            ['house_id' => $house->id, 'time' => Carbon::parse('08:00')],
        ];

        $this->repo->insertMultipleReservationData($data);

        // assert
        $res = HouseReservation::where('house_id', $house->id)->get();
        $this->assertEquals(count($data), count($res));
    }

    public function test_showTimesByHouseIdAndDate()
    {
        $date = "2023/07/07";

        $customer = User::factory()->create();
        $house = House::factory()->create();

        $res1 = HouseReservation::create([
            'house_id' => $house->id,
            'time' => Carbon::parse('09:00')
        ]);
        $res2 = HouseReservation::create([
            'house_id' => $house->id,
            'time' => Carbon::parse('15:00')
        ]);

        Order::create(['customer_id' => $customer->id, 'reservation_id' => $res1->id, 'date' => Carbon::parse($date)]);
        Order::create(['customer_id' => $customer->id, 'reservation_id' => $res1->id, 'date' => Carbon::parse("2023/10/10")]);

        // act
        $res = $this->repo->showTimesByHouseIdAndDate($house->id, $date);

        // assert
        $this->assertEquals(count([$res1, $res2]), count($res));
        $this->assertEquals(true, $res[0]->has_ordered);
        $this->assertGreaterThan($res[0]->time, $res[1]->time);
    }

    public function tearDown(): void
    {
        Artisan::call('migrate:refresh');

        parent::tearDown();
    }
}
