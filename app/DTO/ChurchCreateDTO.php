<?php 

namespace App\DTO;

class ChurchCreateDTO extends AbstractDTO {

   public function __construct(
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