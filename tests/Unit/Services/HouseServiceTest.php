<?php

namespace Tests\Unit;
use Mockery;
use Mockery\MockInterface;

use PHPUnit\Framework\TestCase;
use App\Http\Services\HouseService;
use App\Http\Repositories\HouseRepository;

class HouseServiceTest extends TestCase
{
    /**
     * test show Item works well
     */
    public function test_showItem(): void
    {
        $id = 1;

        $repo = Mockery::mock(HouseRepository::class);
        $repo->shouldReceive('getHouseById')->once()->andReturn(
            (object) ['id' => $id, "name" => "my pretty house"]
        );

        $serv = new HouseService($repo);
        $res = $serv->showItem($id);

        $this->assertEquals($res->id, $id);
    }
}
