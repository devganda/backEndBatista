<?php 

namespace App\DTO;

class ChurchDTO extends AbstractDTO {

    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
        public readonly string $address,
        public readonly string $cnpj,
        public readonly string $UF,
        public readonly string $date_inauguration
    ) 
    {
    } 
}