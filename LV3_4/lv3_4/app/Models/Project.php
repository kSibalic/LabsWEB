<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'user_id',
        'naziv',
        'opis',
        'cijena',
        'obavljeni_poslovi',
        'datum_pocetka',
        'datum_zavrsetka',
    ];

    public function voditelj()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function clanovi()
    {
        return $this->belongsToMany(User::class, 'project_user');
    }
}

