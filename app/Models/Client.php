<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'nit',
        'name',
        'last_name',
        'birth_date',
    ];

    public function Sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function Contacs()
    {
        return $this->hasMany(Contac::class);
    }
}
