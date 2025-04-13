<?php

namespace LaraSlim\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $email
 * @property string $password
 *
 * @method static \Illuminate\Database\Eloquent\Collection<int, \LaraSlim\Models\User> all()
 * @method static \LaraSlim\Models\User|null find(int $id)
 * @method static \LaraSlim\Models\User create(array<string, mixed> $attributes)
 */
class User extends Model
{
    protected $table = 'users';
    protected $guarded = [];

}
