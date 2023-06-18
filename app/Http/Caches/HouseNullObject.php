<?php

namespace App\Http\Caches;

class HouseNullObject
{
    private $data;

    public function __construct()
    {
        $this->data = ["name" => "", "city" => "", "city_dist" => ""];
    }

    public function __get($property)
    {
        return $this->data[$property] ?? "";
    }

    public function __set($property, $val)
    {
        // do nothing
    }
}
