<?php

namespace App\Http\Services;

interface Service
{
    public function showAllItems(array $query);

    public function showItem(string $id);

    public function insertItem(array $data);

    public function updateItem(string $id, array $data);

    public function destroyItem(string $id);
}