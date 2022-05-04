<?php

namespace Tests1Doc;

class UserBusiness
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function getUserByName(
        string $name
    ) : array {
        if (empty($name)) {
            return [];
        }

        return $this->userRepository->getUsersByName($name);
    }

    public function createUser(
        string $name
    ) {
        if (empty($name)) {
            return [];
        }

        $id = $this->userRepository->insertUser($name);
        
        if (empty($id)) {
            return [];
        }

        return $this->userRepository->getUserById($id);
    }
}