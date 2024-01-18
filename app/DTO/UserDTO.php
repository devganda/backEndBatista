<?php

namespace App\DTO;

class UserDTO extends AbstractDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $email_verified_at,
        public readonly string $password
    ){}
}
