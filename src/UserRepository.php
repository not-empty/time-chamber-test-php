<?php

namespace Tests1Doc;

use Illuminate\Database\Capsule\Manager as Database;

class UserRepository {

    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getUsersByName(
        string $name
    ) : array {
        return $this->db
            ->table('user')
            ->select('id', 'name')
            ->where('name', $name)
            ->get();
    }

    public function insertUser(
        string $name
    ) : string {
        return $this->db
            ->table('user')
            ->insert(
                [
                    'name' => $name
                ]
            );
    }

    public function getUserById(
        string $userId
    ) : array {
        return $this->db
            ->table('user')
            ->find($userId);
    }
}