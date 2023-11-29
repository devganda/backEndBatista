<?php 

namespace App\DTO;

class MemberDTO extends AbstractDTO{

    public function __construct(
        public readonly int $church_id,
        public readonly string $name,
        public readonly string $email,
        public readonly int $age,
        public readonly string $date_admission_church,
        public readonly string $phone,
        public readonly string $UF,
        public readonly string $address
    ){}
}