<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    /**
     * Um modelo Member que pertence a uma Church
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function church() {
        return $this->belongsTo(Church::class, 'church_id');
    }
}
