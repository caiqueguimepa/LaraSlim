<?php

namespace LaraSlim\Services;

use LaraSlim\DTOs\UserDTO;
use LaraSlim\Models\User;

class UserServices
{

    public function store(UserDTO $userDTO): User
    {
        return User::create([
            'name' => $userDTO->name,
            'email' => $userDTO->email,
            'password' => password_hash($userDTO->password, PASSWORD_BCRYPT),
        ]);
    }
}