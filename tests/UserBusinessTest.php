<?php

namespace Tests1Doc;

use Mockery;
use PHPUnit\Framework\TestCase;
use Tests1Doc\UserRepository;

class UserBusinessTest extends TestCase
{
    /**
     * @covers \Tests1Doc\UserBusiness::__construct
     */
    public function testCreateBusiness()
    {
        $userRepositorySpy = Mockery::spy(UserRepository::class);
        $userBusiness = new UserBusiness($userRepositorySpy);
        $this->assertInstanceOf(UserBusiness::class, $userBusiness);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}