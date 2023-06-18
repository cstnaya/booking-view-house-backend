<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;

use App\Http\Caches\HouseCache;
use App\Models\House;
use Exception;

class HouseRepository
{
    private $HouseCache;

    public function __construct(HouseCache $HouseCache)
    {
        $this->HouseCache = $HouseCache;
    }

    /**
     * @param array data
     * @param collect
     */
    public function insertHouseData(array $data)
    {
        return House::create($data);
    }

    public function getHousesByQuery(array $query)
    {
        $query_string = "select houses.*, cities.city, city_dists.dist_name, house_types.house_type from houses 
            join cities on cities.id = houses.city_id 
            join city_dists on city_dists.id = city_dist_id
            join house_types on house_types.id = house_type_id";
        $query_paras = [];
        $need_and = false;

        if (isset($query['keyword'])) {
            $query_string .= " where name like ? ";
            $query_paras[] = "%" . $query['keyword'] . "%";
            $need_and = true;
        }
        if (isset($query['city'])) {
            $query_string .= ($need_and) ? " and " : ' where ';
            $query_string .= " houses.city_id = ? ";
            $query_paras[] = $query['city'];
            $need_and = true;
        }
        if (isset($query['city_dist'])) {
            $query_string .= ($need_and) ? " and " : ' where ';
            $query_string .= " city_dist_id = ? ";
            $query_paras[] = $query['city_dist'];
            $need_and = true;
        }
        if (isset($query['house_type'])) {
            $query_string .= ($need_and) ? " and " : ' where ';
            $query_string .= " house_type_id = ? ";
            $query_paras[] = $query['house_type'];
            $need_and = true;
        }
        if (isset($query['price_min'])) {
            $query_string .= ($need_and) ? " and " : ' where ';
            $query_string .= " price >= ? ";
            $query_paras[] = $query['price_min'];
            $need_and = true;
        }
        if (isset($query['price_max'])) {
            $query_string .= ($need_and) ? " and " : ' where ';
            $query_string .= " price <= ? ";
            $query_paras[] = $query['price_max'];
            $need_and = true;
        }
        if (isset($query['cook'])) {
            $query_string .= ($need_and) ? " and " : ' where ';
            $query_string .= " can_cook is true";
            $need_and = true;
        }
        if (isset($query['pet'])) {
            $query_string .= ($need_and) ? " and " : ' where ';
            $query_string .= " can_pet is true";
            $need_and = true;
        }
        if (isset($query['stop'])) {
            $query_string .= ($need_and) ? " and " : ' where ';
            $query_string .= " near_stop is true";
            $need_and = true;
        }
        if (isset($query['parking'])) {
            $query_string .= ($need_and) ? " and " : ' where ';
            $query_string .= " has_parking is true";
            $need_and = true;
        }
        if (isset($query['elevator'])) {
            $query_string .= ($need_and) ? " and " : ' where ';
            $query_string .= " has_elevator is true";
            $need_and = true;
        }

        $result = DB::select($query_string, $query_paras);

        return $result;
    }

    /**
     * Show all houses owned by one owner.
     * 
     * @param string id
     * @return collection
     */
    public function getHousesByOwnerId(string $id)
    {
        $res = DB::select(
            '
            select houses.*, cities.city, city_dists.dist_name, house_types.house_type from houses 
            join cities on cities.id = city_id 
            join city_dists on city_dists.id = city_dist_id
            join house_types on house_types.id = house_type_id
            where owner_id = ?',
            [$id]
        );
        return $res;
    }

    /**
     * Show a house's metadata.
     * @param string id
     * @return collect 
     */
    public function getHouseById(string $id)
    {
        $cacheData = $this->HouseCache->getHouseCache($id);

        if ($cacheData) {
            return $cacheData;
        } else {
            // read from db
            $data = DB::table('houses')
                ->join('cities', 'cities.id', '=', 'city_id')
                ->join('city_dists', 'city_dists.id', '=', 'city_dist_id')
                ->join('house_types', 'house_types.id', '=', 'house_type_id')
                ->where('houses.id', $id)
                ->select('houses.*', 'cities.city', 'city_dists.dist_name', 'house_types.house_type')
                ->first();

            if ($data) {
                $this->HouseCache->putHouseCache($data);
            } else {
                $this->HouseCache->putNullObject($id);
            }

            return $data;
        }
    }

    /**
     * @param string id
     * @param array data
     * @return boolean true if update succeed
     */
    public function updateHouseById(string $id, array $data)
    {
        try {
            DB::beginTransaction();

            $res = House::where('id', $id)->update($data);
            $this->HouseCache->clearHouseCache($id);

            DB::commit();
            return $res;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param string id
     * @return bool true if delete success, false if data not exist
     */
    public function destroyById(string $id)
    {
        try {
            DB::beginTransaction();

            House::where('id', $id)->delete();
            $this->HouseCache->clearHouseCache($id);

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
