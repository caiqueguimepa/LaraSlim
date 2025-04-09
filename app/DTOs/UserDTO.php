<?php

namespace LaraSlim\DTOs;

class UserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    )
    {
    }
    public  function withPassword(): UserDTO
    {
        return new self(
          $this->name,
          $this->email,
          password_hash($this->password, PASSWORD_BCRYPT)
        );
    }
    public function withoutPassword(): UserDTO
    {
        return new self(
            $this->name,
            $this->email,
            ''
        );
    }
}