<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    use HasFactory;
    protected $table = "members";
    protected $fillable = [
        'id',
        'name',
        'email',
        'age',
        'date_admission_church',
        'phone',
        'UF',
        'address',
        'church_id'
    ];

    public function church():BelongsTo {
        return $this->belongsTo(Church::class, 'church_id');
    }

    public function findMembersByChurchID(string $churchID):Collection
    {
        return Member::where('church_id', $churchID)->get();
    }
}
