<?php

namespace LaraSlim\Services;

use Illuminate\Database\Eloquent\Collection;
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
    public function all(): Collection
    {
        return User::all();
    }
    public function find(int $id): ?User
    {
        return User::find($id) ?? null;
    }
    public function update(int $id, UserDTO $userDTO): ?User
    {
        $user = $this->find($id);

        if ($user) {

            $user->update([
                'name' => $userDTO->name,
                'email' => $userDTO->email,
            ]);

            return $this->find($id);
        }

        return null;
    }
    public function delete(int $id): bool
    {
        $user = $this->find($id);

        if ($user) {
            return $user->delete();
        }

        return false;
    }
}