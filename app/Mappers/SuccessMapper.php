<?php 

namespace App\Mappers;

use App\DTO\SuccessDTO;

class SuccessMapper{

   public static function toDTO(string $message):SuccessDTO
   {
      return new SuccessDTO($message);
   }
}