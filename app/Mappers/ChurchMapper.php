<?php 
namespace App\Mappers;

use App\DTO\ChurchDTO;
use App\Models\Church;

class ChurchMapper{

   public static function toDTO(Church $church):ChurchDTO{

      return new ChurchDTO(
         $church->id,
         $church->name,
         $church->email,
         $church->address,
         $church->cnpj,
         $church->UF,
         $church->date_inauguration
      );
   }
}