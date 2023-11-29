<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    /**
     * Um modelo Member que pertence a uma Church
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function church() {
        return $this->belongsTo(Church::class, 'church_id');
    }
}
