<?php

namespace App\DTO;

class UserDTO extends AbstractDTO
{
    public function __construct(
        public readonly string $name,
        public readonly int $church_id,
        public readonly string $email,
        public readonly string $password
    ){}
}
