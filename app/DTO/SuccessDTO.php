<?php 

namespace App\DTO;

class SuccessDTO extends AbstractDTO{

   public function __construct(
      public readonly string $message
   ){}
}