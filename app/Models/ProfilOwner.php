<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilOwner extends Model
{
    protected $fillable = [
        'nama_owner',
        'email',
        'nama_studio',
        'foto',
    ];
}
