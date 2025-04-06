<?php

namespace Feature;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SkeletonProjectPHP\DTOs\UserDTO;
use SkeletonProjectPHP\Models\User;
use SkeletonProjectPHP\Services\UserServices;

class UserServiceTest extends TestCase
{
    #[Test]
    public function store()
    {
        $userDTO = new UserDTO('Caique', 'caique1@email.com', '123456');
        $userServiceMock = $this->createMock(UserServices::class);

        $userServiceMock->expects($this->once())
            ->method('store')
            ->with($userDTO);

        $result = $userServiceMock->store($userDTO);

        $this->assertInstanceOf(User::class, $result);
        $this->assertNotEmpty($result);
    }
    #[Test]
    public function get()
    {
        $this->assertTrue(true);
    }
}