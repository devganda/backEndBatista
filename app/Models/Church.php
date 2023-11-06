<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Church extends Model
{
    use HasFactory;

    protected $table = "churchs";

    protected $fillable = ['name', 'email', 'cnpj', 'address', 'UF', 'date_inauguration'];
    
    /**
     * Um modelo Church que tem muitos membros (um-para-muitos)
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function members()
    {
        return $this->hasMany(Member::class, 'church_id', 'id');
    }
}
