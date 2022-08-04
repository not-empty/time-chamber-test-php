<?php

namespace Tests1Doc;

use Illuminate\Database\Capsule\Manager as Database;
use Illuminate\Database\Eloquent\Collection;

class ItemRepository
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getItemById(
        int $id
    ): Collection
    {
        return $this->db
            ->table('items')
            ->find($id);
    }

    public function getItemByName(
        string $name
    ): Collection
    {
        return $this->db
            ->table('items')
            ->select('*')
            ->where('name', $name)
            ->get();
    }

    public function insertItem(
        string $name,
        string $type,
        float $weight,
        string $description
    )
    {
        return $this->db
            ->table('items')
            ->insert([
                'name' => $name,
                'type' => $type,
                'weight' => $weight,
                'description' => $description,
            ]);
    }

    public function updateItem(
        int $id,
        string $name,
        string $type,
        float $weight,
        string $description
    )
    {
        return $this->db
            ->table('items')
            ->where('id', $id)
            ->update([
                'name' => $name,
                'type' => $type,
                'weight' => $weight,
                'description' => $description,
            ]);
    }

}