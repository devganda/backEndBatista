<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;

class Church extends Model
{
    use HasFactory;

    protected $table = "churchs";

    protected $fillable = ['name', 'email', 'cnpj', 'address', 'UF', 'date_inauguration'];

    /**
     * Um modelo Church que tem muitos membros (um-para-muitos)
     */
    public function members():hasMany
    {
        return $this->hasMany(Member::class, 'church_id', 'id');
    }

    public function users():hasMany
    {
        return $this->hasMany(User::class);
    }

}
