<?php

use Illuminate\Database\Eloquent\Collection;
use LaraSlim\Models\User;
use LaraSlim\Services\UserServices;
use LaraSlim\DTOs\UserDTO;

beforeEach(function () {
    $this->userService = $this->createMock(UserServices::class);
});

test('create a new user', function () {
    $userDTO = (new UserDTO('User Teste', 'user@email.com', '12345678'))->withPassword();

    $this->userService
        ->expects($this->once())
        ->method('store')
        ->with($userDTO)
        ->willReturn(new User());

    $response = $this->userService->store($userDTO);

    $this->assertInstanceOf(User::class, $response);
});
test('get all users', function () {
    $this->userService
        ->expects($this->once())
        ->method('all')
        ->willReturn(new Collection([
            new User(),
            new User(),
            new User(),
        ]));

    $response = $this->userService->all();

    $this->assertInstanceOf(Collection::class, $response);
});
test('find user by id', function () {
    $this->userService
        ->expects($this->once())
        ->method('find')
        ->with(1)
        ->willReturn(new User());

    $response = $this->userService->find(1);

    $this->assertInstanceOf(User::class, $response);
});
test('update an existing user', function () {
    $userId = 1;
    $userDTO = (new UserDTO('Updated User', 'updated@email.com', 'newpassword'))->withPassword();

    $updatedUser = new User();
    $updatedUser->id = $userId;
    $updatedUser->name = 'Updated User';
    $updatedUser->email = 'updated@email.com';

    $this->userService
        ->expects($this->once())
        ->method('update')
        ->with($userId, $userDTO)
        ->willReturn($updatedUser);

    $response = $this->userService->update($userId, $userDTO);

    $this->assertInstanceOf(User::class, $response);
    $this->assertEquals('Updated User', $response->name);
    $this->assertEquals('updated@email.com', $response->email);
});
test('delete an existing user', function () {
    $userId = 1;

    $this->userService
        ->expects($this->once())
        ->method('delete')
        ->with($userId)
        ->willReturn(true);

    $response = $this->userService->delete($userId);

    $this->assertTrue($response);
});
test('try to delete a non-existent user', function () {
    $nonExistentUserId = 999;

    $this->userService
        ->expects($this->once())
        ->method('delete')
        ->with($nonExistentUserId)
        ->willReturn(false);

    $response = $this->userService->delete($nonExistentUserId);

    $this->assertFalse($response);
});