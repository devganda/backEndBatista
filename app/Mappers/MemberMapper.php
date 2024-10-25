<?php 

namespace App\Mappers;

use App\DTO\MemberDTO;
use App\Models\Member;
use Illuminate\Database\Eloquent\Collection;

class MemberMapper{
   
   public static function toCollection(Collection $members): Collection
   {
      return $members->map(function ($member) {
         return self::toDTO($member); 
      });
   }

   public static function toDTO(Member $member):MemberDTO
   {
      return new MemberDTO(
         $member->id,
         $member->church_id,
         $member->name,
         $member->email,
         $member->age,
         $member->data_admission_church,
         $member->phone,
         $member->UF,
         $member->address
      );
   }
}